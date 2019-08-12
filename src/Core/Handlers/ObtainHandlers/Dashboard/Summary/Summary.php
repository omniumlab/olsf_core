<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 12/03/2018
 * Time: 15:56
 */

namespace Core\Handlers\ObtainHandlers\Dashboard\Summary;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class Summary implements ValueInterface
{

    /**
     * @var ListValueInterface Class Variables
     * "title" string
     * "icon" string
     * "value" mixed
     * "iconColor" string|null
     */
    private $variables;

    public function __construct($title, $icon, $value)
    {
        $this->variables = new BaseListValue();
        $this->setTitle($title);
        $this->setIcon($icon);
        $this->setValue($value);
    }

    /**
     * @param $title string
     */
    public function setTitle($title){
        $this->variables->setValue($title, "title");
    }

    /**
     * @param $icon string
     */
    public function setIcon($icon){
        $this->variables->setValue($icon, "icon");
    }

    /**
     * @param $value mixed
     */
    public function setValue($value){
        $this->variables->setValue($value, "value");
    }

    /**
     * @param $iconColor string
     */
    public function setIconColor($iconColor){
        if (strpos($iconColor, '#') === false) {
            $iconColor = "#" . $iconColor;
        }
        $this->variables->setValue($iconColor, "iconColor");
    }


    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}