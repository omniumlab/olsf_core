<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values;


class BorderThick implements BorderTypeValueInterface
{
    function getValue(): string
    {
        return "thick";
    }

}