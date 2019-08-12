<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/04/2018
 * Time: 18:47
 */

namespace Core\Reflection\Builders;


interface ObjectCreatorInterface
{
    public function createObject(string $className, array $objects = []);

    public function exists(string $className);
}