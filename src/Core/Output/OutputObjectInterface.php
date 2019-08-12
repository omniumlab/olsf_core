<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/07/2017
 * Time: 20:38
 */

namespace Core\Output;


use Core\Fields\Output\OutputFieldInterface;

interface OutputObjectInterface
{
    /**
     * @return array Array key-value with all the information of this object
     */
    public function toArray();

    /**
     * @param OutputFieldInterface[] $fields
     *
     * @return void
     */
    public function setFields($fields);

    /**
     * @param string $field
     */
    public function removeField(string $field);

    /**
     * Adds raw data to the object. If some value exists, it will be overwritten with the new value.
     *
     * @param array $rawData The array data with fields name in the keys.
     *
     * @return void
     */
    public function addRawData(array $rawData);


    /**
     * Add a value into rawData array
     * @param $index mixed
     * @param $value mixed
     */
    public function addRawDataValue($index, $value);

    /**
     * @param OutputFieldInterface|string $field
     *
     * @return mixed
     */
    public function getValue($field);
}