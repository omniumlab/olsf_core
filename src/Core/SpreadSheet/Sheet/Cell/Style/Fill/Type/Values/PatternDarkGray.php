<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class PatternDarkGray implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_dark_gray";
    }
}