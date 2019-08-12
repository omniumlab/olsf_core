<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/08/2018
 * Time: 10:23
 */

namespace Core\Language\Factory;


use Core\Language\Language;
use Core\Language\LanguageInterface;

class LanguageFactory implements LanguageFactoryInterface
{
    public function make(int $id): LanguageInterface
    {
        return new Language($id);
    }
}