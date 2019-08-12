<?php


namespace Core\SpreadSheet\Sheet;


use Core\SpreadSheet\Sheet\Cell\CellInterface;
use Core\SpreadSheet\Sheet\ImageObject\ImageObject;
use Core\SpreadSheet\Sheet\ImageObject\ImageObjectInterface;

interface SheetInterface
{
    /**
     * @return null|string
     */
    function getTitle(): ?string;

    /**
     * @param string $value
     * @return SheetInterface
     */
    function setTitle(string $value): SheetInterface;

    /**
     * @param int $col
     * @param int $row
     * @return CellInterface
     */
    function getCell(int $col, int $row): CellInterface;


    /**
     * @return CellInterface
     */
    function getActiveCell(): CellInterface;

    /**
     * @param string $value
     * @return SheetInterface
     */
    function nextCellValue(string $value): SheetInterface;

    /**
     * @param int $colsToSkip
     * @return SheetInterface
     */
    function skipCols(int $colsToSkip): SheetInterface;

    /**
     * @param int $rowsToSkip
     * @return SheetInterface
     */
    function skipRows(int $rowsToSkip): SheetInterface;

    /**
     * @param int $col
     * @return SheetInterface
     */
    function nextRow(int $col = 1): SheetInterface;

    /**
     * @param string $value
     * @return SheetInterface
     */
    function activeCellValue(string $value): SheetInterface;

    /**
     * @return SheetInterface
     */
    function nextCell(): SheetInterface;

    /**
     * @param int $fromCol
     * @param int $fromRow
     * @param int $toCol
     * @param int $toRow
     * @return CellInterface[]
     */
    function getCells(int $fromCol, int $fromRow, int $toCol, int $toRow): array;


    /**
     * @return CellInterface[]
     */
    function getAllCells(): array;

    /**
     * @param int $fromCol
     * @param int $fromRow
     * @param int $toCol
     * @param int $toRow
     * @return SheetInterface
     */
    function mergeCellsByColumnsAndRows(int $fromCol, int $fromRow, int $toCol, int $toRow): SheetInterface;

    /**
     * @return CellInterface []
     */
    function getMergeCells():array;

    function addImage(ImageObjectInterface $imageObject): SheetInterface;

    function getImages(): array;

    /**
     * Clear the sheet
     */
    function clear(): void;
}