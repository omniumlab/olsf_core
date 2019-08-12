<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 15/02/2018
 * Time: 15:05
 */

namespace Core\Handlers\Filters;


interface FilterInterface
{
    public function getColumn();

    public function getComparison();

    public function getValue();

    public function getConnector();
}