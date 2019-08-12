<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 18/01/2019
 * Time: 13:46
 */

namespace Core\Fields\Output;


interface DependentFieldInterface
{
    function getFieldDependent(): ?string;
}
