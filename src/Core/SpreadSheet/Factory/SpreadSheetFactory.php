<?php


namespace Core\SpreadSheet\Factory;


use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\Factory\SheetFactoryInterface;
use Core\SpreadSheet\SpreadSheet;
use Core\SpreadSheet\SpreadSheetInterface;

class SpreadSheetFactory implements SpreadSheetFactoryInterface
{
    /** @var SheetFactoryInterface */
    private $sheetFactory;

    /** @var CellFactoryInterface */
    private $cellFactory;

    public function __construct(SheetFactoryInterface $sheetFactory, CellFactoryInterface $cellFactory)
    {
        $this->sheetFactory = $sheetFactory;
        $this->cellFactory = $cellFactory;
    }

    function create(?string $sheetTitle = null): SpreadSheetInterface
    {
        return new SpreadSheet($this->sheetFactory, $this->cellFactory, $sheetTitle);
    }

}
