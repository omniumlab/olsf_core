<?php


namespace Core\Handlers\ObtainHandlers\Map\Data;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class Coordinate implements ValueInterface
{

    /**
     * @var ListValueInterface Class variables
     * "data" array
     * "label" string
     */
    private $variables;

    public function __construct($latitude, $longitude)
    {
        $this->variables = new BaseListValue();

        $this->variables->setValue($latitude, "latitude");
        $this->variables->setValue($longitude, "longitude");
    }

    public function getValues()
    {
        return $this->variables->getValues();
    }
}