<?php


namespace Core\SpreadSheet\Sheet\ImageObject;


interface ImageObjectInterface
{
    function setPath(string $path): ImageObjectInterface;

    function getPath(): string;

    function setCoordinate(string $coordinate): ImageObjectInterface;

    function getCoordinate(): string;

    function setProportionalResize(bool $value = true): ImageObjectInterface;

    function setWidth(float $value): ImageObjectInterface;

    function setHeight(float $height): ImageObjectInterface;

    function getProportionalResize(): bool;

    function getWidth(): ?float;

    function getHeight(): ?float;

    function getRowHeight(): ?float;

    function setRowHeight(?float $rowHeight): ImageObjectInterface;

    function getColWidth(): ?float;

    function setColWidth(?float $colWidth): ImageObjectInterface;

    function getCol(): ?string;

    function getRow(): ?int;
}