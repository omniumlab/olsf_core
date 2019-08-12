<?php

namespace Core\Handlers\ObtainHandlers\Propel\ListHandler;
use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 05/01/2018
 * Time: 13:56
 *
 * @todo Implementar esto en el handler de la lista
 */
class Summatory implements ValueInterface
{

    /**
     * @var ListValueInterface Class variables
     * "value" string
     * "name" string
     * "description" string
     * "icon" string
     */
    private $variables;

    function __construct($value, $name, $description = null, $icon = null)
    {
        $this->variables = new BaseListValue();

        $this->setValue($value);
        $this->setName($name);
        $this->setDescription($description);
        $this->setIcon($icon);
    }

    /**
     * @param $value string
     */
    public function setValue($value)
    {
        $this->variables->setValue($value, "value");
    }

    /**
     * @param $name string
     */
    public function setName($name)
    {
        $this->variables->setValue($name, "name");
    }

    /**
     * @param $description string
     */
    public function setDescription($description)
    {
        $this->variables->setValue($description, "description");
    }

    /**
     * @param $icon string
     */
    public function setIcon($icon)
    {
        $this->variables->setValue($icon, "icon");
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}