<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values;


class Center implements HorizontalAlignmentValueInterface
{
    function getValue(): string
    {
        return "horizontal_center";
    }


}