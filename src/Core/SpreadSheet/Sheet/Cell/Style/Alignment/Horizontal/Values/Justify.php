<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Justify implements HorizontalAlignmentValueInterface
{

    function getValue(): string
    {
        return "horizontal_justify";
    }
}