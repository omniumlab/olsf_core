<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class PatternDarkDown implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_dark_down";
    }
}