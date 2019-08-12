<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class None implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_none";
    }
}