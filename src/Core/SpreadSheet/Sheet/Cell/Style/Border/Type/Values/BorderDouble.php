<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values;


class BorderDouble implements BorderTypeValueInterface
{
    function getValue(): string
    {
        return "double";
    }

}