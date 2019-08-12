<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class PatternLightDown implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_light_down";
    }
}