<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/10/2017
 * Time: 14:12
 */

namespace Core\Entities\Options;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class BaseValue implements ValueInterface
{

    /**
     * @var ListValueInterface Class Variables
     * "id" string
     * "value" string
     */
    private $variables;


    /**
     * BaseValue constructor.
     * @param string $id
     * @param string $value
     */
    public function __construct($id, $value)
    {
        $this->variables = new BaseListValue();
        $this->setId($id);
        $this->setVisualValue($value);

    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->variables->getValue("id");
    }


    public function getValue(){
        return $this->variables->getValue("value");
    }

    /**
     * @param $id string
     */
    public function setId($id){
        $this->variables->setValue($id, "id");
    }


    /**
     * @param $value string
     */
    public function setValue($value){
        $this->variables->setValue($value, "value");
    }

    public function setVisualValue($value)
    {
        $visualValue = str_replace('_', ' ', $value);
        $visualValue = ucwords($visualValue);

        $this->setValue($visualValue);
    }


    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}