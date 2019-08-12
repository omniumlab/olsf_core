<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 20/10/17
 * Time: 10:06
 */

namespace Core\Entities\Options;


use Core\ListValue\ValueInterface;

interface EntityOptionsInterface extends ValueInterface
{
    function addItemToVariablesList($arrayName, $value);

    /**
     * @param $variableName string
     *
     * @return mixed
     */
    function getVariable($variableName);

    function setVariable($variableName, $value);

}