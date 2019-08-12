<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values;


class Justify implements VerticalAlignmentValueInterface
{
    function getValue(): string
    {
        return "vertical_justify";
    }

}