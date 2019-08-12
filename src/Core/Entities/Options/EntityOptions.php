<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 20/10/17
 * Time: 10:14
 */

namespace Core\Entities\Options;


use Core\ListValue\BaseListValue;

class EntityOptions implements EntityOptionsInterface
{

    /**
     * @var BaseListValue Class variables
     * "visualName" string
     */
    private $variables;


    public function __construct()
    {
        $this->variables = new BaseListValue();
    }

    public function addItemToVariablesList($arrayName, $value, $index = null)
    {
        $this->variables->addItemToArray($arrayName, $value,null,$index);
    }

    /**
     * @param $variableName string
     *
     * @return mixed
     */
    public function getVariable($variableName)
    {
        return $this->variables->getValue($variableName);
    }

    public function setVariable($variableName, $value)
    {
        $this->variables->setValue($value, $variableName);
    }

    public function getValues()
    {
        return $this->variables->getValues();
    }


}