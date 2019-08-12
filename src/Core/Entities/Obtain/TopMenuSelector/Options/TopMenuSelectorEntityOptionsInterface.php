<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 26/04/2019
 * Time: 11:54
 */

namespace Core\Entities\Obtain\TopMenuSelector\Options;


use Core\Entities\Options\EntityOptionsInterface;

interface TopMenuSelectorEntityOptionsInterface extends EntityOptionsInterface
{
    function addColumn(string $fieldName, string $visualName, array $values);
}
