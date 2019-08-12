<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 07/03/2019
 * Time: 19:14
 */

namespace Core\Handlers\TranslationHandler;


use Core\Auth\Roles\RoleInterface;
use Core\Commands\CommandInterface;
use Core\Commands\ListHandlerCommandInterface;
use Core\Commands\Symfony\ListHandlerCommand;
use Core\Fields\Input\BaseInputField;
use Core\Fields\Input\InputFieldInterface;
use Core\Fields\Input\SymfonyBaseImage;
use Core\Fields\Output\OutputFieldBase;
use Core\Fields\Output\OutputFieldInterface;
use Core\Fields\Output\Text;
use Core\Handlers\ChangeHandlers\ChangeHandlerInterface;
use Core\Handlers\Handler;
use Core\Handlers\ObtainHandlers\ListHandlerInterface;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Repository\Translation\TranslationRepositoryInterface;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\Map\ColumnMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Connection\ConnectionInterface;

abstract class TranslationListHandler extends Handler implements ListHandlerInterface
{
    private $manualFieldsValues = [];
    private $allFieldsRemoved = false;

    /**
     * @var SymfonyBaseImage[]
     */
    private $imageFields = [];
    /**
     * @var TableMap[]
     */
    private $tableMaps = [];
    /**
     * @var InputFieldInterface[]
     */
    private $fields = [];
    /**
     * @var null|ConnectionInterface If this parameter is not null, an internal transaction will not be performed.
     */
    private $connection;
    /** @var TranslationRepositoryInterface */
    private $translationRepository;

    public function __construct(string $method, bool $individual, TextHandlerInterface $textHandler, TranslationRepositoryInterface $translationRepository)
    {
        parent::__construct($method, $individual, $textHandler);
        $this->translationRepository = $translationRepository;
    }

    /**
     * Method to get summations of this list
     *
     * @return \Core\Handlers\ObtainHandlers\Propel\ListHandler\Summatory[]
     */

    public function getSummaries(): array
    {
        return [];
    }


    private function initializeFields()
    {
        foreach ($this->tableMaps as $tableMap) {
            foreach ($tableMap->getColumns() as $column) {
                $this->addField($column->getFullyQualifiedName());
            }
        }
    }


    public function removeAllFields()
    {
        $this->fields = [];
        $this->allFieldsRemoved = true;
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
     * @param OutputFieldInterface|string|ColumnMap $field
     *
     * @return void
     */
    public function addField($field)
    {


        $this->fields[$field->getName()] = $field;
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
     * @param mixed $object
     * @param bool $exceptionOnRequiredFields
     *
     * @throws \Core\Exceptions\InputRequiredException
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
    public function
    getTableMaps()
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

    public function getFields(): array
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

    public function setup()
    {

        $field = new  Text($this->getTextHandler()->get("Name"));
        $field->setPrimaryKey(true);
        $this->addField($field);
        $this->addField(new Text("tables"));
        $this->addField(new Text("columns"));
        $this->addField(new Text("table"));
        foreach ($this->translationRepository->getLanguages() as $lang) {
            if ($lang !== $this->translationRepository->getDefaultLang())
                $this->addField(new Text($lang));
        }

    }

    public function handle($command): HandlerResponseInterface
    {
        $listCommand = new ListHandlerCommand($command);
        $filter_tables = $command->get("filter_tables");
        $filter_columns = $command->get("filter_columns");

        $filter_name = array_key_exists("Name", $listCommand->getFilters()) ? $listCommand->getFilters()["Name"] : "";
        $sort = array_key_exists("sort", $command->all()) ? $listCommand->getSort()[0] === "Name" ? $listCommand->getSort()[1] : "" : "";
        $sort_lang = array_key_exists("sort", $command->all()) ? $listCommand->getSort()[0] !== "Name" ? $listCommand->getSort() : [] : [];
        $data = array();
        $total = 0;
        if ($filter_tables && $filter_columns) {
            $limit = $command->get("limit");
            $offset = $command->get("offset");
            $values = $this->translationRepository->getTranslations($filter_tables, $offset, $limit, $filter_name, $sort, $filter_columns);
            foreach ($values as $value) {
                if ($value !== null) {
                    $langa = ["Name" => $value, "table" => $filter_tables];
                    foreach ($this->translationRepository->getLanguages() as $lang) {
                        if ($lang !== $this->translationRepository->getDefaultLang())
                            $langa[$lang] = $this->translationRepository->getKeyValueFromFilter($filter_tables, $lang, $value);
                    }
                    $data[] = $langa;
                }


            }
            foreach ($listCommand->getFilters() as $key => $value) {
                if ($key !== "Name" && $key !== "tables" && $key !== "columns")
                    $data = $this->preg_grep_keys($value, $data, $key);

            }
            if (count($values) > 0)
                $total = $this->translationRepository->getCount($filter_tables, $filter_name, $sort);

            if (count($sort_lang) > 0)
                if ($sort_lang[1] == "ASC")
                    usort($data, $this->asc($sort_lang[0]));
                else
                    usort($data, $this->desc($sort_lang[0]));

        }
        return new SuccessHandlerResponse(HttpCodes::CODE_OK, ["rows" => $data, "total" => $total]);


    }

    function preg_grep_keys($pattern, $input, $lang)
    {
        $result = array();
        foreach ($input as $key => $values) {
            if (preg_match("/(" . $pattern . ")/", $values[$lang])) {
                $result[$key] = $values;
            }
        }
        return $result;
    }

    function asc($key)
    {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }

    function desc($key)
    {
        return function ($a, $b) use ($key) {
            return strnatcmp($b[$key], $a[$key]);
        };
    }


    /**
     * @return int
     */
    public function getCount()
    {
        return 0;
    }

    public function setIdParent($id)
    {

    }
}