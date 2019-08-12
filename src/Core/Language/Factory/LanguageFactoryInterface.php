<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/08/2018
 * Time: 10:13
 */

namespace Core\Language\Factory;


use Core\Language\LanguageInterface;

interface LanguageFactoryInterface
{
    public function make(int $id): LanguageInterface;
}