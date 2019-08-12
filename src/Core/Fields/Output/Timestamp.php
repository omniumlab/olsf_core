<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 21/07/2017
 * Time: 9:15
 */

namespace Core\Fields\Output;


class Timestamp extends OutputFieldBase
{
    private $format = "d/m/Y H:i:s";

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function formatValue($value)
    {
        if ($value === null) {
            return $value;
        }

        $value = new \DateTime($value);
        if ($value->format("Y") < 1900) {
            return null;
        }

        return $value->format($this->format);
    }


}