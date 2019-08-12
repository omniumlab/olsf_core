<?php


namespace Core\SpreadSheet\Sheet\Factory;


use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\SheetInterface;
use Core\SpreadSheet\Sheet\Sheet;

class SheetFactory implements SheetFactoryInterface
{
    /** @var CellFactoryInterface */
    private $cellFactory;

    public function __construct(CellFactoryInterface $cellFactory)
    {
        $this->cellFactory = $cellFactory;
    }

    function create(?string $title = null): SheetInterface
    {
        return new Sheet($this->cellFactory, $title);
    }

}
