<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 19:13
 */

namespace Core\Fields\Output;


class NumberFloat extends OutputFieldBase
{
    private $decimals = 2;
    private $decimalPoint = '.';
    private $thousandSeparator = ',';

    public function setFormat($decimals, $decimalPoint, $thousandSeparator)
    {
        assert(is_int($decimals), '$decimals must be an integer');

        $this->decimals = $decimals;
        $this->decimalPoint = $decimalPoint;
        $this->thousandSeparator = $thousandSeparator;
    }

    public function formatValue($value)
    {
        if ($value === null) {
            return null;
        }
        return number_format($value, $this->decimals, $this->decimalPoint, $this->thousandSeparator);
    }

}