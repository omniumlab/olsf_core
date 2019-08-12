<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Font;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FontBold implements StyleInterface
{

    /**
     * @return mixed|string
     */
    function getValue()
    {
        return "bold";
    }

    function getName(): string
    {
        return "font_bold";
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