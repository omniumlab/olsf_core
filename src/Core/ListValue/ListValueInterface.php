<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 25/10/17
 * Time: 16:32
 */

namespace Core\ListValue;



interface ListValueInterface
{
    /**
     * @return array
     */
    public function getValues();

    /**
     * @param $value mixed
     * @param null|string $key
     */
    public function setValue($value, $key = null);

    /**
     * @param $key int|string
     * @return mixed
     */
    public function getValue($key);

    /**
     * @param $arrayName string
     * @param $value mixed
     * @param mixed $key
     */
    public function addItemToArray($arrayName, $value, $key = null);
}