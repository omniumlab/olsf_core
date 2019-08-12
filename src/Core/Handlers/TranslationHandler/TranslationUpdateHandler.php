<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/03/2019
 * Time: 10:30
 */

namespace Core\Handlers\TranslationHandler;


use Core\Auth\Roles\RoleInterface;
use Core\Commands\CommandInterface;
use Core\Exceptions\InputRequiredException;
use Core\Fields\Input\BaseInputField;
use Core\Fields\Input\InputFieldInterface;
use Core\Fields\Input\SymfonyBaseImage;
use Core\Handlers\ChangeHandlers\ChangeHandlerInterface;
use Core\Handlers\ChangeHandlers\Propel\AbstractChangeHandler;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Repository\Translation\TranslationRepositoryInterface;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\Map\ColumnMap;
use Propel\Runtime\Map\TableMap;
use Symfony\Component\Ldap\Adapter\ConnectionInterface;

abstract class TranslationUpdateHandler extends Handler implements ChangeHandlerInterface
{

    /**
     * @var TableMap[]
     */
    private $tableMaps = [];

    /**
     * @var InputFieldInterface[]
     */
    private $fields = [];

    /**
     * @var bool
     */
    private $allFieldsRemoved = false;

    /**
     * @var SymfonyBaseImage[]
     */
    private $imageFields = [];


    private $manualFieldsValues = [];
    /**
     * @var null|ConnectionInterface If this parameter is not null, an internal transaction will not be performed.
     */
    private $connection;

    /** @var TranslationRepositoryInterface */
    private $translation;

    /**
     * @param string $method
     * @param bool $individual
     * @param TextHandlerInterface $textHandler
     * @param TranslationRepositoryInterface $translationRepository
     */
    public function __construct(
        string $method,
        bool $individual,
        TextHandlerInterface $textHandler,
        TranslationRepositoryInterface $translationRepository
    )
    {
        $this->translation = $translationRepository;
        parent::__construct($method, $individual, $textHandler);
    }

    public function handle($command): HandlerResponseInterface
    {
        $values = $command->get("other_values");
        foreach ($command->all() as $key => $value) {
            if ($key !== "XDEBUG_SESSION_START" && $key !== "other_values") {
                $this->translation->setKeyValue($values["table"], $values["Name"], $key, $value);

            }
        }
        return new SuccessHandlerResponse(HttpCodes::CODE_OK, []);
    }

    private function initializeFields()
    {
        foreach ($this->tableMaps as $tableMap) {
            foreach ($tableMap->getColumns() as $column) {
                $this->addField($column->getFullyQualifiedName());
            }
        }
    }

    private function createField(ColumnMap $column)
    {
        $valueSet = $column->getValueSet();
        $fieldName = $column->getFullyQualifiedName();

        $field = new BaseInputField($fieldName);
        $field->setRequired($column->isNotNull())
            ->setType($column->getType())
            ->setForeignKey($column->isForeignKey())
            ->setValues($this->createScreenNames($valueSet))
            ->setDefaultValue($column->getDefaultValue());

        return $field;
    }

    public function removeAllFields()
    {
        $this->fields = [];
        $this->allFieldsRemoved = true;
    }

    private function createScreenNames($enumValues)
    {
        foreach ($enumValues as $key => &$value) {
            $value = ucfirst(strtolower(str_replace("_", " ", $value)));
        }

        return $enumValues;
    }


    public function removeField($name)
    {
        if (!empty($this->fields) && $this->hasField($name)) {
            unset($this->fields[$name]);

            if (count($this->fields) === 0)
                $this->allFieldsRemoved = true;
        }
    }

    /**
     * @param bool $allFieldsRemoved
     */
    public function setAllFieldsRemoved(bool $allFieldsRemoved)
    {
        $this->allFieldsRemoved = $allFieldsRemoved;
    }


    /**
     * @param InputFieldInterface|string|ColumnMap $column
     *
     * @return void
     */
    public function addField($column)
    {
        if ($column instanceof InputFieldInterface) {
            $field = $column;
        } else {
            if (!($column instanceof ColumnMap)) {
                $column = $this->findColumnInTableMaps($column);
            }

            $field = $this->createField($column);
        }

        $this->fields[$field->getInputKeyName()] = $field;
    }

    /**
     * @param (InputFieldInterface|string|ColumnMap)[] $column
     *
     * @return void
     */
    public function addFields($columns)
    {
        array_map([$this, "addField"], $columns);
    }

    public function findColumnInTableMaps($name)
    {
        foreach ($this->getTableMaps() as $tableMap) {
            if ($tableMap->hasColumn($name)) {
                return $tableMap->getColumn($name);
            }
        }

        return null;
    }


    /**
     * @param CommandInterface $command
     * @param mixed $object
     * @param bool $exceptionOnRequiredFields
     *
     */
    protected function fillObject(CommandInterface $command, $object, $exceptionOnRequiredFields = true)
    {
        $incorrectFields = [];

        foreach ($this->getFields() as $field) {

            try {
                $value = $this->findValue($field, $command);
            } catch (\Exception $e) {
                continue;
            }

            try {
                if ($value === null && $field->isRequired()) {
                    $incorrectFields[] = $field->getInputKeyName();
                } else if ($field instanceof SymfonyBaseImage && (new \ReflectionClass($object))->getShortName() === $field->getModelClassName()) {
                    $this->imageFields[$field->getModelClassName()][] = $field;
                } else {
                    if ($this->existField($object, $field->getName())) {
                        $object->setByName($field->getName(), $value, TableMap::TYPE_COLNAME);
                    }
                }
            } catch (\ReflectionException $ex) {
                throw new \LogicException("Error trying to get class name from the object ", var_export($object, true));
            }
        }

        foreach ($this->manualFieldsValues as $field => $value) {
            if ($this->existField($object, $field))
                $object->setByName($field, $value, TableMap::TYPE_COLNAME);
        }

        if ($exceptionOnRequiredFields && !empty($incorrectFields)) {
            throw new InputRequiredException($incorrectFields);
        }

        $this->onAfterFill($object);
    }

    protected function onAfterFill($object)
    {

    }

    /**
     * @param InputFieldInterface $field
     *
     * @param \Core\Commands\CommandInterface $command
     *
     * @return mixed
     */
    private function findValue(InputFieldInterface $field, CommandInterface $command)
    {
        return $field->findValue($command);
    }

    /**
     * @param $object mixed
     * @param $fieldName string
     *
     * @return bool
     */
    public function existField($object, $fieldName)
    {
        return in_array($fieldName, array_keys($object->toArray(TableMap::TYPE_COLNAME)));
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     * @param $object ActiveRecordInterface
     * @param $id
     *
     * @throws \ReflectionException
     */
    public function saveImages(CommandInterface $command, $object, $id)
    {
        $className = (new \ReflectionClass($object))->getShortName();

        if (in_array($className, array_keys($this->imageFields))) {
            /** @var SymfonyBaseImage $imageField */
            foreach ($this->imageFields[$className] as $imageField) {
                $image = $imageField->findValue($command);
                if (!empty($image))
                    $imageField->saveImage($image, $id);
            }
        }
    }

    /**
     * @return \Propel\Runtime\Map\TableMap[]
     */
    public function getTableMaps()
    {
        return $this->tableMaps;
    }

    public function addTableMap(TableMap $tableMap)
    {
        $this->tableMaps[] = $tableMap;
    }

    /**
     * @param $name
     *
     * @return null|\Core\Fields\Input\InputFieldInterface
     */
    public function getField($name)
    {
        if (!$this->hasField($name)) {
            return null;
        }

        return $this->getFields()[$name];
    }

    public function hasField($name)
    {
        $fields = $this->getFields();

        return array_key_exists($name, $fields);
    }

    public function getFields()
    {
        if (empty($this->fields) && !$this->allFieldsRemoved) {
            $this->initializeFields();
        }

        return $this->fields;
    }

    public function addManualvalue($field, $value)
    {
        if (!empty($this->fields) && $this->hasField($field)) {
            unset($this->fields[$field]);
        }

        $this->manualFieldsValues[$field] = $value;
    }

    /**
     * @return null|ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param null|ConnectionInterface $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}