<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/01/2018
 * Time: 16:48
 */

namespace Core\Fields\Output;


class VisualEnum extends OutputFieldBase
{
    private $valueSet;

    public function __construct($name, $valueSet, $alias = null)
    {
        $this->valueSet = $valueSet;
        parent::__construct($name, $alias);
    }

    public function formatValue($value)
    {
        $enumValue = $this->valueSet[$value];
        $enumValue = ucfirst(strtolower(str_replace("_", " ", $enumValue)));

        return $enumValue;
    }

}