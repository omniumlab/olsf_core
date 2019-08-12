<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\VerticalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface VerticalAlignmentInterface extends StyleInterface
{
    /**
     * @param VerticalAlignmentValueInterface $value
     * @return StyleInterface
     */
    public function setValue($value): StyleInterface;
}