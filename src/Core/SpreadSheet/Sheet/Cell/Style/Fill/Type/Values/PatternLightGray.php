<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class PatternLightGray implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_light_gray";
    }
}