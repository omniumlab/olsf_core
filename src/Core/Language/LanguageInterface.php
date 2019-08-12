<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/08/2018
 * Time: 7:36
 */

namespace Core\Language;


interface LanguageInterface
{
    public function getId(): int;

    public function isDefault(): bool;

    public function setDefault(bool $default): void;
}