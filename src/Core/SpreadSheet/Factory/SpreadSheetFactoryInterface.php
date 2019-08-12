<?php


namespace Core\SpreadSheet\Factory;


use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\Factory\SheetFactoryInterface;
use Core\SpreadSheet\SpreadSheetInterface;

interface SpreadSheetFactoryInterface
{

    /**
     * Creates a new Workbook
     * @param string|null $sheetTitle
     * @return SpreadSheetInterface
     */
    function create(?string $sheetTitle = null): SpreadSheetInterface;

    /**
     * Open an existing file and obtain its Woorkbook.
     * By default only file data will be loaded, set $onlyData to false to load styling and data validation between others.
     * SheetTitles is an array that contain the specific sheets you want to load. If not specified, the whole document will be loaded.
     *
     * @param string $path
     * @param bool $onlyData
     * @param array|null $sheetTitles
     * @return SpreadSheetInterface
     */
    //function loadFromFile(string $path, bool $onlyData = true, array $sheetTitles = null): SpreadSheetInterface;
}
