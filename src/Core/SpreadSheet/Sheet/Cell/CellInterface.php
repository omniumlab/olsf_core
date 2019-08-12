<?php


namespace Core\SpreadSheet\Sheet\Cell;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface CellInterface
{

    /**
     * Set the given value in the indicated position
     * @return CellInterface
     */
    function setValue(string $value, bool $isFormula = false): CellInterface;

    /**
     * @return mixed
     */
    function getValue();

    function getCol(): int;

    function getRow(): int;

    function addStyle(StyleInterface $style): CellInterface;

    /**
     * @param StyleInterface[] $styles
     * @return CellInterface
     */
    function addStyles(array $styles): CellInterface;

    function removeStyleByIndex(int $index): CellInterface;

    function removeStyle(StyleInterface $style): CellInterface;

    /**
     * @return CellInterface
     */
    function getMergeCell(): CellInterface;

    function mergeCell(CellInterface $cell): CellInterface;

    /**
     * @return StyleInterface[]
     */
    function getStyles(): array;

    function isFormula(): bool;

}