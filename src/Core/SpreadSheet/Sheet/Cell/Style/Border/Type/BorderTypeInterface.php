<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type;

use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface BorderTypeInterface extends StyleInterface
{
    /**
     * @param BorderTypeValueInterface $value
     * @return StyleInterface
     */
    public function setValue($value): StyleInterface;
}