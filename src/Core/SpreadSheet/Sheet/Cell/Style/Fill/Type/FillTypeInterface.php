<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type;


use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\FillTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface FillTypeInterface extends StyleInterface
{

    /**
     * @param FillTypeValueInterface $value
     * @return StyleInterface
     */
    public function setValue($value): StyleInterface;
}