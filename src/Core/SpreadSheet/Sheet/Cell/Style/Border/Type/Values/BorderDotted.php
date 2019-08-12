<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values;


class BorderDotted implements BorderTypeValueInterface
{
    function getValue(): string
    {
        return "dotted";
    }

}