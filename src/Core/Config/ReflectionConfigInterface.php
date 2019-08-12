<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 21:27
 */

namespace Core\Config;


interface ReflectionConfigInterface
{
    public function getFallbackCommandBusClassName(): string;

    public function getFallbackCommandClassName($originalCommanName): string;
}