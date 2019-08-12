<?php


namespace Core\SpreadSheet;


use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\Factory\SheetFactoryInterface;
use Core\SpreadSheet\Sheet\SheetInterface;

class SpreadSheet implements SpreadSheetInterface
{

    /**
     * @var SheetInterface[]
     */
    private $sheets;
    /**
     * @var SheetFactoryInterface
     */
    private $sheetFactory;
    /**
     * @var SheetInterface
     */
    private $activeSheet;
    /**
     * @var CellFactoryInterface
     */
    private $cellFactory;

    public function __construct(SheetFactoryInterface $sheetFactory, CellFactoryInterface $cellFactory, ?string $sheetTitle = null)
    {
        $this->sheets = [];
        $this->sheetFactory = $sheetFactory;
        $this->cellFactory = $cellFactory;
        $this->addNewSheet($sheetTitle);
    }

    /**
     * @param string|null $title
     * @param int|null $index
     * @return SheetInterface
     */
    function addNewSheet(?string $title = null, ?int $index = null): SheetInterface
    {
        $sheet = $this->sheetFactory->create($title);

        if ($index === null) {
            array_push($this->sheets, $sheet);
            $newSheetIndex = count($this->sheets) - 1;
            $this->setActiveSheet($newSheetIndex);
            return $this->activeSheet;
        }

        $extractedValues = array_splice($this->sheets, $index, 0, $sheet);
        array_push($this->sheets, $extractedValues);
        $this->setActiveSheet($index);
        return $this->activeSheet;
    }

    /**
     * @param string $sheetTitle
     * @return SheetInterface
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    function setActiveSheetByTitle(string $sheetTitle): SheetInterface
    {
        $index = $this->getSheetIndexByTitle($sheetTitle);
        if ($index !== null) {
            $this->setActiveSheet($index);
            return $this->activeSheet;
        }
        return null;
    }

    /**
     * @param int $index
     * @return SheetInterface
     */
    function setActiveSheet(int $index): SheetInterface
    {
        if ($index >= count($this->sheets))
            return null;

        $this->activeSheet = &$this->sheets[$index];
        return $this->activeSheet;
    }

    /**
     * @return SheetInterface
     */
    function getActiveSheet(): SheetInterface
    {
        return $this->activeSheet;
    }

    /**
     * @return SheetInterface[]
     */
    function getSheets(): array
    {
        return $this->sheets;
    }


    /**
     * @param int $index
     * @return SpreadSheetInterface
     */
    function removeSheet(int $index): SpreadSheetInterface
    {
        $activeSheetIndex = array_search($this->activeSheet, $this->sheets);
        unset($this->sheets[$index]);
        $this->sheets = array_values($this->sheets);

        if ($activeSheetIndex === $index) {
            $this->setActiveSheet(count($this->sheets) - 1);
        }
        return $this;
    }

    /**
     * @param string $sheetTitle
     * @return SpreadSheetInterface
     */
    function removeSheetByTitle(string $sheetTitle): SpreadSheetInterface
    {
        $index = $this->getSheetIndexByTitle($sheetTitle);
        if ($index !== null) {
            $this->removeSheet($index);
        }
        return $this;
    }

    /**
     * Clear the Woorkbook to prevent memory leak
     */
    function clear(): void
    {
        $this->activeSheet = null;
        foreach ($this->sheets as $sheet)
            $sheet->clear();

        unset($this->sheets);
        $this->sheets = [];
    }

    private function getSheetByTitle(string $sheetTitle)
    {
        foreach ($this->sheets as $index => $sheet) {
            if (strcasecmp($sheetTitle, $sheet->getTitle() === 0)) {
                return $sheet;
            }
        }
        return null;
    }

    private function getSheetIndexByTitle(string $sheetTitle)
    {
        foreach ($this->sheets as $index => $sheet) {
            if (strcasecmp($sheetTitle, $sheet->getTitle() === 0)) {
                return $index;
            }
        }
        return null;
    }
}
