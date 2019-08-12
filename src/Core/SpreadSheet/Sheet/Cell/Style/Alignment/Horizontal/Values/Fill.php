<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Fill implements HorizontalAlignmentValueInterface
{

    function getValue(): string
    {
        return "horizontal_fill";
    }
}