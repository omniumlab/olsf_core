<?php


namespace Core\SpreadSheet\Sheet;


use Core\SpreadSheet\Sheet\Cell\CellInterface;
use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\ImageObject\ImageObject;
use Core\SpreadSheet\Sheet\ImageObject\ImageObjectInterface;

class Sheet implements SheetInterface
{

    /**
     * @var string
     */
    private $title;
    /**
     * @var CellFactoryInterface
     */
    private $cellFactory;
    /**
     * @var CellInterface[]
     */
    private $cells = [];

    /**
     * @var CellInterface[]
     */
    private $mergeCells;

    /**
     * @var CellInterface
     */
    private $activeCell;

    /** @var ImageObjectInterface[] */
    private $images = [];

    public function __construct(CellFactoryInterface $cellFactory, ?string $title = null)
    {
        $this->title = $title;
        $this->cellFactory = $cellFactory;
        $this->activeCell = $this->getCell(1, 1);
    }

    function setTitle(string $value): SheetInterface
    {
        $this->title = $value;
        return $this;
    }

    function getTitle(): ?string
    {
        return $this->title;
    }

    function getCell(int $col, int $row): CellInterface
    {
        foreach ($this->cells as $cell) {
            if ($cell->getCol() === $col && $cell->getRow() === $row)
                return $cell;
        }
        $cell = $this->cellFactory->create($col, $row);
        $this->activeCell = $cell;
        array_push($this->cells, $cell);
        return $cell;
    }

    function getCells(int $fromCol, int $fromRow, int $toCol, int $toRow): array
    {
        $cells = [];
        $fromColAux = $fromCol;

        while ($fromRow <= $toRow) {
            while ($fromColAux <= $toCol) {
                array_push($cells, $this->getCell($fromColAux, $fromRow));
                $fromColAux++;
            }
            $fromColAux = $fromCol;
            $fromRow++;
        }
        return $cells;
    }

    function getAllCells(): array
    {
        return $this->cells;
    }

    function getActiveCell(): CellInterface
    {
        return $this->activeCell;
    }

    function nextCellValue(string $value): SheetInterface
    {
        $this->activeCell = $this->getCell($this->activeCell->getCol() + 1, $this->activeCell->getRow());
        $this->activeCell->setValue($value);
        return $this;
    }

    function skipCols(int $colsToSkip): SheetInterface
    {
        $cell = $this->getCell($this->activeCell->getCol() + $colsToSkip, $this->activeCell->getRow());
        $this->activeCell = $cell;
        return $this;
    }

    function skipRows(int $rowsToSkip): SheetInterface
    {
        $cell = $this->getCell($this->activeCell->getCol(), $this->activeCell->getRow() + $rowsToSkip);
        $this->activeCell = $cell;
        return $this;
    }

    function nextRow(int $col = 1): SheetInterface
    {
        $cell = $this->getCell($col, $this->activeCell->getRow() + 1);
        $this->activeCell = $cell;
        return $this;
    }

    function activeCellValue(string $value): SheetInterface
    {
        $this->activeCell->setValue($value);
        return $this;
    }

    function nextCell(): SheetInterface
    {
        $this->activeCell = $this->getCell($this->activeCell->getCol() + 1, $this->activeCell->getRow());
        return $this;
    }

    function mergeCellsByColumnsAndRows(int $fromCol, int $fromRow, int $toCol, int $toRow): SheetInterface
    {
        $this->mergeCells[] = $this->getCell($fromCol, $fromRow)->mergeCell($this->getCell($toCol, $toRow));
        return $this;
    }

    function addImage(ImageObjectInterface $imageObject): SheetInterface
    {
        array_push($this->images, $imageObject);
        return $this;
    }

    /**
     * @return ImageObjectInterface[]
     */
    function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return array
     */
    function getMergeCells(): array
    {
        return empty($this->mergeCells) ? [] : $this->mergeCells ;
    }

    function clear(): void
    {
        // TODO: Implement clear() method.
    }

}
