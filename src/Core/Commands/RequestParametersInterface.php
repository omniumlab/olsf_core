<?php


namespace Core\Commands;


interface RequestParametersInterface
{
    function get(string $name, $default = null);
}
