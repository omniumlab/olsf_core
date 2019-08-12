<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 16/06/2018
 * Time: 20:23
 */

namespace Core\Fields\Input;

interface TimeInterface
{
    /**
     * @return int
     */
    public function getMinutes(): int;

    /**
     * @return int
     */
    public function getSeconds(): int;
}