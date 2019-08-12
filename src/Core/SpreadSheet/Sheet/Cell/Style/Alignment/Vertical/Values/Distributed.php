<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values;


class Distributed implements VerticalAlignmentValueInterface
{
    function getValue(): string
    {
        return "vertical_distributed";
    }

}