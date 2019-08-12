<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2018
 * Time: 18:33
 */

namespace Core\Reflection;


interface NameInterface
{
    public function getCamelCase(bool $suffix = true) : string;
    public function getSnakeCase() : string;
}