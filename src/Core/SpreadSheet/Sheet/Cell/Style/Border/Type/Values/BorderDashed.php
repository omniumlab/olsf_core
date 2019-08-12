<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values;


class BorderDashed implements BorderTypeValueInterface
{
    function getValue(): string
    {
        return "dashed";
    }


}