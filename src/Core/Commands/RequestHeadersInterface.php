<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/07/2018
 * Time: 21:02
 */

namespace Core\Commands;


interface RequestHeadersInterface
{
    /**
     * @param string $name
     *
     * @return array|string
     */
    public function getHeaderValue(string $name);
}