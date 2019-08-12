<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/08/2018
 * Time: 20:40
 */

namespace Core\Enums;


use Core\Enums\Identifier\EnumValueIdentifierInterface;

interface EnumValueInterface
{
    public function getEnumValueIdentifier(): EnumValueIdentifierInterface;
}