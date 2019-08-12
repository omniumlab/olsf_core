<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Font;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FontUnderline implements StyleInterface
{

    function getName(): string
    {
        return "font_underline";
    }

    function getValue()
    {
        return "underline";
    }

    function setValue($value): StyleInterface
    {
        return $this;
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}