<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/03/2018
 * Time: 10:04
 */

namespace Core\Handlers\ObtainHandlers\Dashboard\Item;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

abstract class Item implements ValueInterface
{
    /**
     * @var ListValueInterface Class Variables
     * "name" string
     * "itemType" string
     * "data" Data[]
     */
    private $variables;

    public function __construct($name = null)
    {
        $this->variables = new BaseListValue();

        if ($name !== null) {
            $this->setName($name);
        }
    }

    /**
     * @param $name string
     */
    public function setName($name)
    {
        $this->variables->setValue($name, "name");
    }

    /**
     * @param $itemType string
     */
    public function setItemType($itemType)
    {
        $this->variables->setValue($itemType, "itemType");
    }

    /**
     * @param $data array
     */
    public function setData($data)
    {
        $this->variables->setValue($data, "data");
    }

    /**
     * @param $colors array
     */
    public function setColors($colors)
    {
        $this->variables->setValue($colors, "colors");
    }   /**
     * @param $colors array
     */
    public function setColorsPie($colors)
    {
        $this->variables->setValue($colors, "colorsPie");
    }

    /**
     * @param $data mixed
     */
    public function addData($data)
    {
        $this->variables->addItemToArray("data", $data);
    }

    public function setVariable($variableName, $value)
    {
        $this->variables->setValue($value, $variableName);
    }

    public function addValueToVariableArray($arrayName, $value, $key = null)
    {
        $this->variables->addItemToArray($arrayName, $value, $key);
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}