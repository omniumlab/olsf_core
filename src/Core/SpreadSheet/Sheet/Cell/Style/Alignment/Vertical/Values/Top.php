<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values;


class Top implements VerticalAlignmentValueInterface
{
    function getValue(): string
    {
        return "vertical_top";
    }

}