<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/08/2018
 * Time: 10:08
 */

namespace Core\Language\Repository;


use Core\Language\LanguageInterface;

interface LanguageRepositoryInterface
{
    public function getByCode(string $code): LanguageInterface;

    public function getDefault(): LanguageInterface;
}