<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/04/2018
 * Time: 17:10
 */

namespace Core\Reflection\Finders;

interface ClassFinderInterface
{
    public function getAllClasses($namespace, string $superClass = '');
}