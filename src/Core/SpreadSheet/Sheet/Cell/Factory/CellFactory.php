<?php


namespace Core\SpreadSheet\Sheet\Cell\Factory;


use Core\SpreadSheet\Sheet\Cell\Cell;
use Core\SpreadSheet\Sheet\Cell\CellInterface;

class CellFactory implements CellFactoryInterface
{

    function create(int $col, int $row, $value = null): CellInterface
    {
        return new Cell($col, $row, $value);
    }
}