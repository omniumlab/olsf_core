<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment;

use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class WrapTextAlignment implements StyleInterface
{

    function getName(): string
    {
        return "alignment_wrap_text";
    }

    function getValue()
    {
        return "wrap";
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