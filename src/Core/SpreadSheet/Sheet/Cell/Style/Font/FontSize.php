<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Font;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FontSize implements StyleInterface
{

    private $value;

    public function __construct(float $value = null)
    {
        if ($value !== null)
            $this->setValue($value);
    }

    function getName(): string
    {
        return "font_size";
    }

    function getValue()
    {
        return $this->value;
    }

    function setValue($value): StyleInterface
    {
        $this->value = $value;
        return $this;
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}