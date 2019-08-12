<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/08/2018
 * Time: 20:34
 */

namespace Core\Enums\Identifier;


interface EnumValueIdentifierInterface
{
    public function getId(): int;

    public function getName(): string;
}