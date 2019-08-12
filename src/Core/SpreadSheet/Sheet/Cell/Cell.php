<?php


namespace Core\SpreadSheet\Sheet\Cell;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class Cell implements CellInterface
{

    /**
     * @var int
     */
    private $col;
    /**
     * @var int
     */
    private $row;
    /**
     * @var mixed
     */
    private $value;
    /**
     * @var StyleInterface[]
     */
    private $styles;

    /** @var CellInterface */
    private $mergeCell;
    /**
     * @var bool
     */
    private $isFormula = false;

    public function __construct(int $col, int $row, $value = null)
    {
        $this->col = $col;
        $this->row = $row;
        $this->styles = [];
        $this->setValue($value);
    }

    function setValue(?string $value, bool $isFormula = false): CellInterface
    {
        $this->value = $value;
        $this->isFormula = $isFormula;
        return $this;
    }

    function getValue()
    {
        return $this->value;
    }

    function getCol(): int
    {
        return $this->col;
    }

    function getRow(): int
    {
        return $this->row;
    }

    function addStyle(StyleInterface $style): CellInterface
    {
        array_push($this->styles, $style);
        return $this;
    }

    function addStyles(array $styles): CellInterface
    {
        $this->styles = array_merge($this->styles, $styles);
        return $this;
    }

    function removeStyleByIndex(int $index): CellInterface
    {
        unset($this->styles[$index]);
        array_values($this->styles);
        return $this;
    }

    function removeStyle(StyleInterface $style): CellInterface
    {
        $index = array_search($style, $this->styles);
        if ($index >= 0 && $index !== false) {
            return $this->removeStyleByIndex($index);
        }
        return $this;
    }

    function getStyles(): array
    {
        return $this->styles;
    }

    function mergeCell(CellInterface $cell): CellInterface
    {
        $this->mergeCell=$cell;
        return $this;
    }
    function getMergeCell():CellInterface{
        return $this->mergeCell;
    }

    /**
     * @return bool
     */
    public function isFormula(): bool
    {
        return $this->isFormula;
    }

}