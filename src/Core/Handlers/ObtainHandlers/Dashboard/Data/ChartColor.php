<?php


namespace Core\Handlers\ObtainHandlers\Dashboard\Data;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class ChartColor implements ValueInterface
{

    /**
     * @var ListValueInterface Class variables
     * "data" array
     * "label" string
     */
    private $variables;

    /**
     * ChartData constructor.
     * @param string $backgroundColor
     * @param string $borderColor
     */

    public function __construct($backgroundColor = "", $borderColor = "")
    {
        $this->variables = new BaseListValue();
        $this->setVariable("backgroundColor", $backgroundColor);
        $this->setVariable("borderColor", $borderColor);

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