<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Font;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FontItalic implements StyleInterface
{

    function getName(): string
    {
        return "font_italic";
    }

    function getValue()
    {
        return "italic";
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