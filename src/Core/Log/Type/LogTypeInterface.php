<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 11:14
 */

namespace Core\Log\Type;


interface LogTypeInterface
{
    public function getSlug(): string;
}