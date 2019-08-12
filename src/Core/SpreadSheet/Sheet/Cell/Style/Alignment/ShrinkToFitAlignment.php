<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class ShrinkToFitAlignment implements StyleInterface
{

    function getValue()
    {
        return "shrink";
    }

    function getName(): string
    {
        return "shrink_fit_alignment";
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