<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 14/09/2018
 * Time: 10:25
 */

namespace Core\Entities;


use Core\Entities\Options\BaseColumn;

interface ColumnableEntityOptionsInterface
{

    /**
     * @return BaseColumn[]
     */
    function getColumns(): array;
}