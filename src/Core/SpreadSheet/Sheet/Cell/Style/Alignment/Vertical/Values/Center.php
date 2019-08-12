<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\VerticalAlignmentValueInterface;

class Center implements VerticalAlignmentValueInterface
{

    function getValue(): string
    {
        return "vertical_center";
    }
}