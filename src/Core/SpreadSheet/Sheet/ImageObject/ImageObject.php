<?php


namespace Core\SpreadSheet\Sheet\ImageObject;

class ImageObject implements ImageObjectInterface
{

    /** @var string */
    private $path;
    /** @var string|null */
    private $coordinate;
    /**
     * @var bool
     */
    private $proportionalResize = true;
    /**
     * @var float|null
     */
    private $width;
    /**
     * @var float|null
     */
    private $height;

    /** @var float|null */
    private $rowHeight;

    /** @var float|null */
    private $colWidth;

    /** @var string|null */
    private $col;

    /** @var int|null */
    private $row;

    public function __construct($path, $coordinate = null)
    {
        $this->path = $path;
        if ($coordinate !== null)
            $this->setCoordinate($coordinate);
    }

    function setPath(string $path): ImageObjectInterface
    {
        $this->path = $path;
        return $this;
    }

    function getPath(): string
    {
        return $this->path;
    }

    function setCoordinate(string $coordinate): ImageObjectInterface
    {
        $this->coordinate = $coordinate;
        $this->col = $coordinate[0];
        $this->row = $coordinate[1];
        return $this;
    }

    function getCoordinate(): string
    {
        return $this->coordinate;
    }

    function setProportionalResize(bool $value = true): ImageObjectInterface
    {
        $this->proportionalResize = $value;
        return $this;
    }

    function setWidth(float $value): ImageObjectInterface
    {
        $this->width = $value;
        return $this;
    }

    function setHeight(float $height): ImageObjectInterface
    {
        $this->height = $height;
        return $this;
    }

    function getProportionalResize(): bool
    {
        return $this->proportionalResize;
    }

    function getWidth(): ?float
    {
        return $this->width;
    }

    function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @return float|null
     */
    public function getRowHeight(): ?float
    {
        return $this->rowHeight;
    }

    /**
     * @param float|null $rowHeight
     * @return ImageObjectInterface
     */
    public function setRowHeight(?float $rowHeight): ImageObjectInterface
    {
        $this->rowHeight = $rowHeight;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getColWidth(): ?float
    {
        return $this->colWidth;
    }

    /**
     * @param float|null $colWidth
     * @return ImageObjectInterface
     */
    public function setColWidth(?float $colWidth): ImageObjectInterface
    {
        $this->colWidth = $colWidth;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRow(): ?int
    {
        return $this->row;
    }

    /**
     * @return string|null
     */
    public function getCol(): ?string
    {
        return $this->col;
    }


}