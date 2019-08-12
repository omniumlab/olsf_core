<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Continuous implements HorizontalAlignmentValueInterface
{

    function getValue(): string
    {
        return "horizontal_continuous";
    }
}