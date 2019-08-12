<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class PatternLightVertical implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_light_vertical";
    }
}