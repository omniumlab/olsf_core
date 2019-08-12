<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class Solid implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_solid";
    }
}