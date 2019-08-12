<?php


namespace Core\SpreadSheet\Sheet\Cell\Factory;

use Core\SpreadSheet\Sheet\Cell\CellInterface;

interface CellFactoryInterface
{

    function create(int $col, int $row, $value = null) : CellInterface;
}