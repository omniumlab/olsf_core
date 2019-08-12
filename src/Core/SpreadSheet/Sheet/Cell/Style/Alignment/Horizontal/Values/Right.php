<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Right implements HorizontalAlignmentValueInterface
{

    function getValue(): string
    {
        return "horizontal_right";
    }
}