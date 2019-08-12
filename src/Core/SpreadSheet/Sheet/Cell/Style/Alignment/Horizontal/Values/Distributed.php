<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Distributed implements HorizontalAlignmentValueInterface
{

    function getValue(): string
    {
        return "horizontal_distributed";
    }
}