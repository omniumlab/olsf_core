<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/08/2018
 * Time: 10:25
 */

namespace Core\Language;


class Language implements LanguageInterface
{
    /**
     * @var bool
     */
    private $default = false;
    /**
     * @var int
     */
    private $id;

    /**
     * Language constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function setDefault(bool $default): void
    {
        $this->default = $default;
    }
}