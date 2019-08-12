<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 18:41
 */

namespace Core\Output;


use Core\Fields\Output\DependentFieldInterface;
use Core\Fields\Output\OutputFieldBase;
use Core\Fields\Output\OutputFieldInterface;
use Core\Fields\Output\Pdf;
use Core\Fields\Output\UriData;

class BaseOutputObject implements OutputObjectInterface
{
    /**
     * @var OutputFieldInterface[]
     */
    private $fields = [];

    private $rawData = [];

    /**
     * @param OutputFieldInterface[] $fields
     * @param array                  $rawData
     */
    public function __construct(array $fields = [], array $rawData = [])
    {
        $this->setFields($fields);
        $this->setRawData($rawData);
    }

    /**
     * @return array Array key-value with all the information of this object
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->getFields() as $field) {
            $result[$field->getAlias()] = $this->getValue($field);
        }

        return $result;
    }

    /**
     * @param OutputFieldInterface|string $field
     *
     * @return mixed
     */
    public function getValue($field)
    {
        if ($field instanceof OutputFieldInterface) {
            $fieldName = $field->getAlias();
        } else {
            $fieldName = $field;
            $field = $this->getField($fieldName);
        }

        if ($field instanceof UriData){
            return $this->getUriDataFromField($field);
        }else if ($field instanceof Pdf){
            return $this->getPdfFromField($field);
        }else if (!isset($this->rawData[$fieldName])) {
            return null;
        }

        $rawData = $this->rawData[$fieldName];

        return $field === null? $rawData : $field->formatValue($rawData);
    }

    /**
     * @return OutputFieldInterface[]
     */
    public function getPrimaryFields(){
        $primaryFields = [];

        foreach ($this->getFields() as $field){
            if ($field->isPrimaryKey()){
                $primaryFields[] = $field;
            }
        }
        return $primaryFields;
    }

    private function getUriDataFromField(UriData $field){
        $value = $this->getDependentFieldValue($field);
        return $field->getUriData($value);
    }

    private function getPdfFromField(Pdf $field)
    {
        $value = $this->getDependentFieldValue($field);
        return $field->getPdfImage($value);
    }

    private function getDependentFieldValue(DependentFieldInterface $field)
    {
        $primaryFields = $this->getPrimaryFields();
        $identifierFieldName = $field->getFieldDependent();

        if ($identifierFieldName !== null){
            assert(isset($this->rawData[$identifierFieldName]), "IdentifierFieldName '" . $identifierFieldName . "' not exists in fields");
            $value = $this->getValue($identifierFieldName);
        }else{
            assert(count($primaryFields) > 0, "UriData fields only can be used in tables with only one PK");
            $value = $this->getValue($primaryFields[0]);
        }

        return $value;
    }

    private function getField($name)
    {
        return isset($this->fields[$name]) ? $this->fields[$name] : null;
    }

    /**
     * @param OutputFieldInterface[] $fields
     */
    public function setFields($fields)
    {
        $this->fields = [];

        foreach ($fields as $field) {
            $this->fields[$field->getAlias()] = $field;
        }
    }

    public function removeField(string $field)
    {
        unset($this->fields[$field]);
    }


    /**
     * @param array $rawData
     *
     * @return mixed
     */
    private function setRawData(array $rawData)
    {
        $this->initializeRawData();
        $this->addRawData($rawData);
    }



    private function initializeRawData()
    {
        $fieldsNames = array_keys($this->fields);
        $nullArray = array_fill(0, count($this->fields), null);

        $this->rawData = array_combine($fieldsNames, $nullArray);
    }

    /**
     * Adds raw data to the object. If some value exists, it will be overwritten with the new value.
     *
     * @param array $rawData The array data with fields name in the keys.
     *
     * @return void
     */
    public function addRawData(array $rawData)
    {
        foreach ($rawData as $alias => $value){
            foreach ($this->getFields() as $field){
                if ($field->getAlias() === $alias){
                    $this->rawData[$field->getAlias()] = $value;
                }
            }

            if (!in_array($alias, array_keys($this->rawData))){
                $this->rawData[$alias] = $value;
            }
        }
    }

    public function addRawDataValue($index, $value)
    {
        $this->rawData[$index] = $value;
    }

    /**
     * @return OutputFieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }


}