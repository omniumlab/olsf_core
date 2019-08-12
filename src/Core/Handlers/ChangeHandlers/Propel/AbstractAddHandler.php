<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/07/2017
 * Time: 11:49
 */

namespace Core\Handlers\ChangeHandlers\Propel;


use Core\Commands\CommandInterface;
use Core\Exceptions\RestException;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAddHandler extends AbstractChangeHandler
{

    /**
     * @var array
     */
    private $emptyObjects = [];

    /**
     * @var array
     */
    private $relatedFields = [];

    /**
     * InsertHandler constructor.
     *
     * @param \Propel\Runtime\Map\TableMap $tableMap
     * @param TextHandlerInterface $textHandler
     * @param ActiveRecordInterface|mixed $emptyObject
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     */
    public function __construct(
        TableMap $tableMap,
        TextHandlerInterface $textHandler,
        $emptyObject = null,
        ConnectionInterface $con = null
    )
    {
        parent::__construct($tableMap, $con, "POST", false, $textHandler);

        if ($emptyObject === null) {
            $emptyObject = $this->createEmptyObject($tableMap);
        }

        $this->emptyObjects[] = $emptyObject;
    }

    /**
     * Add other tables to the insert. If passed by parameter $localField and $foreignField,
     * the local field will have the value of the foreign field.
     *
     * @param TableMap $tableMap
     * @param string $localField
     * @param string $foreignField
     */
    public function addTable(TableMap $tableMap, $localField = null, $foreignField = null)
    {
        $this->addTableMap($tableMap);

        $emptyObject = $this->createEmptyObject($tableMap);

        if ($localField !== null && $foreignField !== null) {
            $this->relatedFields[$foreignField] = $localField;
        }

        $this->emptyObjects[] = $emptyObject;
    }

    /**
     * Empty the emptyObjects array to make another insert.
     */
    public function clear()
    {
        $this->setAllFieldsRemoved(false);
        unset($this->emptyObjects);
        foreach ($this->getTableMaps() as $tableMap) {
            $this->emptyObjects[] = $this->createEmptyObject($tableMap);
        }
    }

    public function setup()
    {
        $this->getFields();
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     *
     * @throws \Core\Exceptions\InputRequiredException
     * @throws \Exception
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        foreach ($this->emptyObjects as $emptyObject) {
            $this->fillObject($command, $emptyObject);
        }

        $this->preInsert();

        $con = $this->getConnection();
        if ($con === null) {
            $con = Propel::getConnection(get_class($this->getTableMaps()[0])::DATABASE_NAME);
            $con->beginTransaction();
        }

        try {
            foreach ($this->emptyObjects as $index => $emptyObject) {
                $this->fillRelatedObjects($command, $emptyObject, $index);
            }

            if ($this->getConnection() === null) {
                $con->commit();
            }
        } catch (\Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $this->getInsertResponse(),  $this->getTextHandler()->get("add_success_response"));
    }

    /**
     * @param $emptyObject
     *
     * @throws \ReflectionException
     * @throws \Core\Exceptions\RestException
     */
    private function fillRelatedObjects(CommandInterface $command, $emptyObject, $index)
    {
        $this->fillRelatedFields($emptyObject);
        $emptyObject->save();
        $this->posInsert($emptyObject);
        $id = $this->getPrimaryValue($emptyObject, $this->getTableMaps()[$index]);
        $this->saveImages($command, $emptyObject, reset($id));
    }

    public function preInsert()
    {

    }

    public function posInsert($object)
    {

    }

    /**
     * If $emptyObject contains a field related to another. The value of said field will be searched in the other
     * objects.
     *
     * @param $emptyObject mixed
     *
     * @throws \Core\Exceptions\RestException
     */
    private function fillRelatedFields($emptyObject)
    {
        foreach ($this->relatedFields as $foreignField => $localField) {
            if ($this->existField($emptyObject, $foreignField)) {
                $emptyObject->setByName($foreignField, $this->getValueFromEmptyObjects($localField),
                    TableMap::TYPE_COLNAME);
            }
        }
    }

    /**
     * Returns the value of the emptyObject that contains a field named as the variable $fieldname.
     *
     * @param $fieldName
     *
     * @return null|mixed
     * @throws \Core\Exceptions\RestException
     */
    public function getValueFromEmptyObjects($fieldName)
    {
        foreach ($this->emptyObjects as $emptyObject) {
            if ($this->existField($emptyObject, $fieldName)) {
                return $emptyObject->getByName($fieldName, TableMap::TYPE_COLNAME);
            }
        }

        throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, "Fieldname '" . $fieldName . "' not found.");
    }

    /**
     * Returns an array with the values that are wanted in the response.
     *
     * @return array
     */
    public function getInsertResponse()
    {
        $response = [];

        foreach ($this->emptyObjects as $i => $object) {
            $table = $this->getTableMaps()[$i];

            $response = array_merge($response, $this->getPrimaryValue($object, $table));
        }

        return $response;
    }

    /**
     * @param mixed|ActiveRecordInterface $object
     *
     * @param TableMap $tableMap
     *
     * @return array
     */
    private function getPrimaryValue($object, TableMap $tableMap)
    {
        $values = [];
        foreach ($tableMap->getPrimaryKeys() as $columnMap) {
            $value = $object->getByName($columnMap->getFullyQualifiedName(), TableMap::TYPE_COLNAME);

            $values[$columnMap->getFullyQualifiedName()] = $value;
        }

        return $values;
    }

    /**
     * @param TableMap $tableMap
     *
     * @return mixed|ActiveRecordInterface
     */
    private function createEmptyObject(TableMap $tableMap)
    {
        $objectClass = $tableMap->getClassName();

        return new $objectClass();
    }

    /**
     * @return array
     */
    public function getEmptyObjects()
    {
        return $this->emptyObjects;
    }

    public function getMainEmptyObject()
    {
        return $this->emptyObjects[0];
    }
}