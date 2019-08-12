<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Format;


use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\FormatValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface FormatInterface extends StyleInterface
{
    /**
     * @param FormatValueInterface $value
     * @return StyleInterface
     */
    public function setValue($value): StyleInterface;
}