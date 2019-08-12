<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Left implements HorizontalAlignmentValueInterface
{

    function getValue(): string
    {
        return "horizontal_left";
    }
}