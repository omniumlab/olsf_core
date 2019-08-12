<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values;


class BorderThin implements BorderTypeValueInterface
{
    function getValue(): string
    {
        return "thin";
    }
}