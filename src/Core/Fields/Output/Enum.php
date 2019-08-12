<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 19:36
 */

namespace Core\Fields\Output;


class Enum extends OutputFieldBase
{
    public function __construct($name, $enumValues, $alias = null)
    {
        parent::__construct($name, $alias);

        parent::setValues($this->createScreenNames($enumValues));

    }

    private function createScreenNames($enumValues)
    {
        foreach ($enumValues as $key => &$value) {
            $value = ucfirst(strtolower(str_replace("_", " ", $value)));
        }

        return $enumValues;
    }

    /**
     * @param $value
     * @param $screenValue
     *
     * @return $this
     */
    public function addScreenEnumValue($value, $screenValue)
    {
        $values = $this->getValues();

        assert(isset($values[$value]),
            "BaseValue '" . $value . "' does not exist in enum '" . $this->getName() . "'");

        $this->addValue($value, $screenValue);


        return $this;
    }

    /**
     * @param $screenValues
     *
     * @return $this
     */
    public function setValues($screenValues)
    {
        foreach ($screenValues as $value => $screenValue) {
            $this->addScreenEnumValue($value, $screenValue);
        }

        return $this;
    }

    public function formatValue($value)
    {
        return $value;
    }


}