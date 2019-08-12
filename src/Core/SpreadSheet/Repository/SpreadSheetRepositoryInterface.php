<?php


namespace Core\SpreadSheet\Repository;


use Core\SpreadSheet\ImportedExcel;
use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\Factory\SheetFactoryInterface;
use Core\SpreadSheet\SpreadSheetInterface;


interface SpreadSheetRepositoryInterface
{

    /**
     * @param SpreadSheetInterface $spreadSheet
     * @param string $fileTitle
     * @param string|null $path
     * @return SpreadSheetRepositoryInterface
     */
    function saveFile(SpreadSheetInterface $spreadSheet, string $fileTitle, ?string $path = null): SpreadSheetRepositoryInterface;

    /**
     * @param string|null $pathAndFileName
     * @return ImportedExcel
     */
    function importFile(string $pathAndFileName = null): ImportedExcel ;


}