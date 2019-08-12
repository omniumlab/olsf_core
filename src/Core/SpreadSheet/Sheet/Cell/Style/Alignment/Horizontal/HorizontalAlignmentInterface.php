<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\HorizontalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface HorizontalAlignmentInterface extends StyleInterface
{
    /**
     * @param HorizontalAlignmentValueInterface $value
     * @return StyleInterface
     */
    public function setValue($value): StyleInterface;
}