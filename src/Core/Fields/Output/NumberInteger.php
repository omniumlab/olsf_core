<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 19:05
 */

namespace Core\Fields\Output;


class NumberInteger extends OutputFieldBase
{
    public function formatValue($value)
    {
        if ($value === null) {
            return null;
        }

        return (int)$value;
    }

}