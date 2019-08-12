<?php


namespace Core\SpreadSheet;

use Core\SpreadSheet\Sheet\SheetInterface;

interface SpreadSheetInterface
{

    /**
     * Add a new sheet to the SpreadSheet
     * @return SheetInterface
     */
    function addNewSheet(?string $title = null, ?int $index = null): SheetInterface;

    /**
     * @param int $index
     * @return SheetInterface
     */
    function setActiveSheet(int $index): SheetInterface;

    /**
     * @param string $sheetTitle
     * @return SheetInterface
     */
    function setActiveSheetByTitle(string $sheetTitle): SheetInterface;

    /**
     * @return SheetInterface
     */
    function getActiveSheet(): SheetInterface;

    /**
     * @param int $index
     * @return SpreadSheetInterface
     */
    function removeSheet(int $index): SpreadSheetInterface;

    /**
     * @param string $sheetTitle
     * @return SpreadSheetInterface
     */
    function removeSheetByTitle(string $sheetTitle): SpreadSheetInterface;

    /**
     * @return SheetInterface[]
     */
    function getSheets(): array;

    /**
     * Clear the SpreadSheet
     */
    function clear(): void;

}