<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/03/2018
 * Time: 10:49
 */

namespace Core\Handlers\ObtainHandlers\Dashboard\Data;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class ChartData implements ValueInterface
{

    /**
     * @var ListValueInterface Class variables
     * "data" array
     * "label" string
     */
    private $variables;

    /**
     * ChartData constructor.
     * @param $data
     * @param $label string
     * @param string|null $color
     */
    public function __construct($data, $label = "", ?string $color = null)
    {
        $this->variables = new BaseListValue();
        $this->setData($data);
        $this->setLabel($label);

        if ($color !== null)
            $this->setColor($color);
    }

    /**
     * @param $data array
     */
    public function setData($data){
        $this->variables->setValue($data, "data");
    }

    /**
     * @param $label string
     */
    public function setLabel($label){
        $this->variables->setValue($label, "label");
    }

    public function setColor(string $color)
    {
        $this->variables->setValue($color, "color");
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}
