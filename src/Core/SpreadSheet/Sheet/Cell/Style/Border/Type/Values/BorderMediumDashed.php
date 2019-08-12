<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values;


class BorderMediumDashed implements BorderTypeValueInterface
{
    function getValue(): string
    {
        return "medium_dashed";
    }

}