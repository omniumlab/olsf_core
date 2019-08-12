<?php


namespace Core\SpreadSheet\Sheet\Factory;


use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\SheetInterface;

interface SheetFactoryInterface
{

    /**
     * @param string|null $title
     * @return SheetInterface
     */
    function create(?string $title = null): SheetInterface;


}
