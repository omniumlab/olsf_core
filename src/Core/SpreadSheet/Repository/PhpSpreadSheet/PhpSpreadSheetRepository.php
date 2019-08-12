<?php


namespace Core\SpreadSheet\Repository\PhpSpreadSheet;

use Core\SpreadSheet\ImportedExcel;
use Core\SpreadSheet\Repository\SpreadSheetRepositoryInterface;
use Core\SpreadSheet\Sheet\Cell\CellInterface;
use Core\SpreadSheet\Sheet\Cell\Factory\CellFactoryInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\ColumnAutoSizeAlignment;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\HorizontalAlignmentInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Center as HorizontalCenter;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Continuous;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Distributed as HorizontalDistributed;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Fill;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\HorizontalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Justify as HorizontalJustify;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Left;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\Right;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\ShrinkToFitAlignment;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Center as VerticalCenter;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\Bottom;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\Distributed as VerticalDistributed;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\Justify as VerticalJustify;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\Top;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\VerticalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\VerticalAlignmentInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\WrapTextAlignment;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Color\BorderAllColor;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Color\BorderBottomColor;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Color\BorderLeftColor;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Color\BorderRightColor;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Color\BorderTopColor;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\BorderAllTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\BorderBottomTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\BorderLeftTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\BorderRightTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\BorderTopTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\BorderTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderDashdot;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderDashed;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderDotted;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderDouble;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderMedium;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderMediumDashdot;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderMediumDashed;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderThick;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderThin;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Creator\StyleCreatorInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\FillEndColor;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\FillStartColor;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\FillTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\FillTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\GradientLinear;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\GradientPath;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\None;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternDarkDown;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternDarkGray;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternDarkHorizontal;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternDarkUp;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternDarkVertical;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternLightDown;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternLightGray;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternLightHorizontal;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternLightUp;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\PatternLightVertical;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\Solid;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontBold;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontColor;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontItalic;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontSize;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontUnderline;
use Core\SpreadSheet\Sheet\Cell\Style\Format\FormatInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\Number;
use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\Percentage;
use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\Time;
use Core\SpreadSheet\Sheet\Factory\SheetFactoryInterface;
use Core\SpreadSheet\Sheet\ImageObject\ImageObjectInterface;
use Core\SpreadSheet\Sheet\SheetInterface;
use Core\SpreadSheet\SpreadSheetInterface;
use Core\Symfony\RootDirObtainerInterface;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Collection\Cells;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class PhpSpreadSheetRepository implements SpreadSheetRepositoryInterface
{

    /** @var string */
    private $publicDir;
    /**
     * @var ImportedExcel
     */
    private $mImportFile;
    /**
     * @var Spreadsheet
     */
    private $phpSpreadSheet;
    /**
     * @var XlsxWriter
     */
    private $writer;
    /**
     * @var XlsxReader
     */
    private $reader;
    /** @var SheetFactoryInterface */
    private $spreadSheet;
    /**
     * @var CellFactoryInterface
     */
    private $cellFactory;
    /** @var StyleCreatorInterface */
    private $styleCreator;
    /**
     * @var SpreadSheetInterface
     */
    private $mSpreadSheet;

    public function __construct(RootDirObtainerInterface $rootDirObtainer, SheetFactoryInterface $spreadSheet, CellFactoryInterface $factory, StyleCreatorInterface $style)
    {
        $this->publicDir = $rootDirObtainer->getPublicDir();
        $this->spreadSheet = $spreadSheet;
        $this->cellFactory = $factory;
        $this->styleCreator = $style;
    }

    function saveFile(SpreadSheetInterface $spreadSheet, string $fileTitle, ?string $path = null): SpreadSheetRepositoryInterface
    {
        $this->mSpreadSheet = $spreadSheet;
        $this->createPhpSpreadSheet();

        if ($path === null) {
            $path = $this->getRootPath();
        }

        $directory = rtrim($path, '/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $this->writer->save($path . $fileTitle . ".xlsx");
        return $this;
    }


    private function getRootPath()
    {
        return $this->publicDir . "/tmp/";
    }

    private function createPhpSpreadSheet()
    {
        $this->phpSpreadSheet = new Spreadsheet();
        $this->phpSpreadSheet->removeSheetByIndex(0);
        $this->writer = new XlsxWriter($this->phpSpreadSheet);

        $this->addSheetsToPhpSpreadSheet();
    }

    private function addSheetsToPhpSpreadSheet()
    {
        foreach ($this->mSpreadSheet->getSheets() as $index => $sheet) {
            if (($title = $sheet->getTitle()) !== null) {
                $newSheet = new Worksheet($this->phpSpreadSheet, $title);
                $this->phpSpreadSheet->addSheet($newSheet, $index);
            } else {
                $this->phpSpreadSheet->createSheet($index);
            }
            $this->phpSpreadSheet->setActiveSheetIndex($index);
            $this->addCellsToPhpSpreadSheet($sheet->getAllCells());
            $this->setCellMerge($sheet);
            $this->setImages($sheet, $this->phpSpreadSheet->getActiveSheet());
        }
    }

    /**
     * @param CellInterface[] $cells
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function addCellsToPhpSpreadSheet(array $cells)
    {
        foreach ($cells as $cell) {
            $phpSpreadCell = $this->phpSpreadSheet->getActiveSheet()
                ->getCellByColumnAndRow($cell->getCol(), $cell->getRow());

            $phpSpreadCell->setValue($cell->getValue());

            $this->addCellStyles($phpSpreadCell, $cell->getStyles());

        }
    }

    /**
     * @param Cell $phpSpreadCell
     * @param array $styles
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function addCellStyles(Cell &$phpSpreadCell, array $styles)
    {
        foreach ($styles as $style) {
            if ($style instanceof FontBold) {
                $phpSpreadCell->getStyle()->getFont()->setBold(true);

            } else if ($style instanceof FontUnderline) {
                $phpSpreadCell->getStyle()->getFont()->setUnderline(true);

            } else if ($style instanceof FontColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color))
                    $phpSpreadCell->getStyle()->getFont()->getColor()->setARGB($color);
                else
                    $phpSpreadCell->getStyle()->getFont()->getColor()->setRGB($color);

            } else if ($style instanceof FontItalic) {
                $phpSpreadCell->getStyle()->getFont()->setItalic(true);

            } else if ($style instanceof FontSize) {
                $phpSpreadCell->getStyle()->getFont()->setSize(floatval($style->getValue()));

            } else if ($style instanceof BorderAllColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getBorders()->getAllBorders()->getColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getBorders()->getAllBorders()->getColor()->setRGB($color);
                }

            } else if ($style instanceof BorderBottomColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getBorders()->getBottom()->getColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getBorders()->getBottom()->getColor()->setRGB($color);
                }

            } else if ($style instanceof BorderLeftColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getBorders()->getLeft()->getColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getBorders()->getLeft()->getColor()->setRGB($color);
                }

            } else if ($style instanceof BorderRightColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getBorders()->getRight()->getColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getBorders()->getRight()->getColor()->setRGB($color);
                }

            } else if ($style instanceof BorderTopColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getBorders()->getTop()->getColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getBorders()->getTop()->getColor()->setRGB($color);
                }

            } else if ($style instanceof FillStartColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getFill()->getStartColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getFill()->getStartColor()->setRGB($color);
                }

            } else if ($style instanceof FormatInterface) {
                $this->setFormatValue($phpSpreadCell, $style->getValue());

            } else if ($style instanceof FillEndColor) {
                $color = $style->getValue();
                if ($this->isARGBColor($color)) {
                    $phpSpreadCell->getStyle()->getFill()->getEndColor()->setARGB($color);
                } else {
                    $phpSpreadCell->getStyle()->getFill()->getEndColor()->setRGB($color);
                }

            } else if ($style instanceof FillTypeInterface) {
                $this->setCellFillType($phpSpreadCell, $style->getValue());

            } else if ($style instanceof BorderTypeInterface) {
                $this->setBorderType($phpSpreadCell, $style);

            } else if ($style instanceof ShrinkToFitAlignment) {
                $phpSpreadCell->getStyle()->getAlignment()->setShrinkToFit(true);

            } else if ($style instanceof WrapTextAlignment) {
                $phpSpreadCell->getStyle()->getAlignment()->setWrapText(true);

            } else if ($style instanceof HorizontalAlignmentInterface) {
                $this->setHorizontalAlignmentValue($phpSpreadCell, $style->getValue());

            } else if ($style instanceof VerticalAlignmentInterface) {
                $this->setVerticalAlignmentValue($phpSpreadCell, $style->getValue());
            } else if ($style instanceof ColumnAutoSizeAlignment) {
                $this->phpSpreadSheet->getActiveSheet()->getColumnDimension($phpSpreadCell->getColumn())->setAutoSize(true);
            }
        }
    }

    private function setCellFillType(Cell &$phpSpreadCell, FillTypeValueInterface $fillType)
    {
        if ($fillType instanceof GradientLinear) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR);

        } else if ($fillType instanceof GradientPath) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_PATH);

        } else if ($fillType instanceof None) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE);

        } else if ($fillType instanceof PatternDarkDown) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_DARKDOWN);

        } else if ($fillType instanceof PatternDarkGray) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_DARKGRAY);

        } else if ($fillType instanceof PatternDarkHorizontal) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_DARKHORIZONTAL);

        } else if ($fillType instanceof PatternDarkUp) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_DARKUP);

        } else if ($fillType instanceof PatternDarkVertical) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_DARKVERTICAL);

        } else if ($fillType instanceof PatternLightDown) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_LIGHTDOWN);

        } else if ($fillType instanceof PatternLightGray) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_LIGHTGRAY);

        } else if ($fillType instanceof PatternLightHorizontal) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_LIGHTHORIZONTAL);

        } else if ($fillType instanceof PatternLightUp) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_LIGHTUP);

        } else if ($fillType instanceof PatternLightVertical) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_LIGHTVERTICAL);

        } else if ($fillType instanceof Solid) {
            $phpSpreadCell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        }
    }

    private function setBorderType(Cell &$phpSpreadCell, BorderTypeInterface $borderType)
    {
        if ($borderType instanceof BorderTopTypeInterface) {
            $borderStyle = $this->getBorderTypeValue($borderType->getValue());
            $phpSpreadCell->getStyle()->getBorders()->getTop()->setBorderStyle($borderStyle);

        } else if ($borderType instanceof BorderRightTypeInterface) {
            $borderStyle = $this->getBorderTypeValue($borderType->getValue());
            $phpSpreadCell->getStyle()->getBorders()->getRight()->setBorderStyle($borderStyle);

        } else if ($borderType instanceof BorderLeftTypeInterface) {
            $borderStyle = $this->getBorderTypeValue($borderType->getValue());
            $phpSpreadCell->getStyle()->getBorders()->getLeft()->setBorderStyle($borderStyle);

        } else if ($borderType instanceof BorderBottomTypeInterface) {
            $borderStyle = $this->getBorderTypeValue($borderType->getValue());
            $phpSpreadCell->getStyle()->getBorders()->getBottom()->setBorderStyle($borderStyle);

        } else if ($borderType instanceof BorderAllTypeInterface) {
            $borderStyle = $this->getBorderTypeValue($borderType->getValue());
            $phpSpreadCell->getStyle()->getBorders()->getAllBorders()->setBorderStyle($borderStyle);
        }
    }

    private function getBorderTypeValue(BorderTypeValueInterface $borderValue)
    {
        if ($borderValue instanceof BorderDashdot) {
            return Border::BORDER_DASHDOT;
        } else if ($borderValue instanceof BorderDashed) {
            return Border::BORDER_DASHED;
        } else if ($borderValue instanceof BorderDotted) {
            return Border::BORDER_DOTTED;
        } else if ($borderValue instanceof BorderDouble) {
            return Border::BORDER_DOUBLE;
        } else if ($borderValue instanceof BorderMedium) {
            return Border::BORDER_MEDIUM;
        } else if ($borderValue instanceof BorderMediumDashdot) {
            return Border::BORDER_MEDIUMDASHDOT;
        } else if ($borderValue instanceof BorderMediumDashed) {
            return Border::BORDER_MEDIUMDASHED;
        } else if ($borderValue instanceof BorderThick) {
            return Border::BORDER_THICK;
        } else if ($borderValue instanceof BorderThin) {
            return Border::BORDER_THIN;
        }
    }

    private function setHorizontalAlignmentValue(Cell &$phpSpreadCell, HorizontalAlignmentValueInterface $value)
    {

        if ($value instanceof HorizontalCenter) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        } else if ($value instanceof Continuous) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER_CONTINUOUS);
        } else if ($value instanceof HorizontalDistributed) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_DISTRIBUTED);
        } else if ($value instanceof Fill) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_FILL);
        } else if ($value instanceof HorizontalJustify) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_JUSTIFY);
        } else if ($value instanceof Left) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        } else if ($value instanceof Right) {
            $phpSpreadCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }
    }

    private function setVerticalAlignmentValue(Cell &$phpSpreadCell, VerticalAlignmentValueInterface $value)
    {
        if ($value instanceof Bottom) {
            $phpSpreadCell->getStyle()->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        } else if ($value instanceof VerticalCenter) {
            $phpSpreadCell->getStyle()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        } else if ($value instanceof VerticalDistributed) {
            $phpSpreadCell->getStyle()->getAlignment()->setVertical(Alignment::VERTICAL_DISTRIBUTED);
        } else if ($value instanceof VerticalJustify) {
            $phpSpreadCell->getStyle()->getAlignment()->setVertical(Alignment::VERTICAL_JUSTIFY);
        } else if ($value instanceof Top) {
            $phpSpreadCell->getStyle()->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        }
    }

    private function isARGBColor(string $color)
    {
        return strlen($color) > 6;
    }

    /**
     * @param string|null $pathAndFileName
     * @return ImportedExcel
     * @throws Exception
     */
    function importFile(string $pathAndFileName = null): ImportedExcel
    {

        $this->reader = new XlsxReader();
        $this->phpSpreadSheet = $this->reader->load($this->getRootPath() . $pathAndFileName);
        $this->mImportFile = new ImportedExcel();
        $this->addPhpSpreadSheetToSheets();
        return $this->mImportFile;
    }

    private function addPhpSpreadSheetToSheets()
    {
        foreach ($this->phpSpreadSheet->getAllSheets() as $index => $sheet) {
            if ($index === 0)
                $this->addCellsToSheets($sheet->getCellCollection());
        }
    }

    /**
     * @param Cells $cells
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function addCellsToSheets(Cells $cells)
    {
        $columns = [];
        $values = array();
        foreach ($cells->getCoordinates() as $cell) {
            $phpSpreadSheet = $this->phpSpreadSheet->getActiveSheet()->getCell($cell);
            if ($phpSpreadSheet->getRow() === 1)
                $columns[] = $phpSpreadSheet->getValue();
            else
                $values[$phpSpreadSheet->getRow() - 2][$columns[ord(strtoupper($phpSpreadSheet->getColumn())) - ord('A')]] = $phpSpreadSheet->getValue();
        }

        $this->mImportFile->setColumns($columns);
        $this->mImportFile->setValues($values);
    }

    private function setFormatValue(Cell $phpSpreadCell, $value)
    {
        if ($value instanceof Percentage) {
            $phpSpreadCell->getStyle()->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE);
        } else if ($value instanceof Number) {
            $phpSpreadCell->getStyle()->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        } else if ($value instanceof Time) {
            $phpSpreadCell->getStyle()->getNumberFormat()->setFormatCode("[h]:mm;@");
        }
    }

    private function setCellMerge(SheetInterface $sheet)
    {
        foreach ($sheet->getMergeCells() as $cell) {
            $this->phpSpreadSheet->getActiveSheet()->mergeCellsByColumnAndRow($cell->getCol(), $cell->getRow(), $cell->getMergeCell()->getCol(), $cell->getMergeCell()->getRow());

        }
    }

    private function setImages(SheetInterface $sheet, Worksheet $phpSheet)
    {
        /** @var ImageObjectInterface $imgObject */
        foreach ($sheet->getImages() as $imgObject) {
            $phpSheet->getRowDimension($imgObject->getRow())->setRowHeight($imgObject->getRowHeight());
            $phpSheet->getColumnDimension($imgObject->getCol())->setWidth($imgObject->getColWidth());

            $drawing = new Drawing();
            $drawing->setPath($imgObject->getPath());
            $drawing->setCoordinates($imgObject->getCoordinate());
            $drawing->setResizeProportional($imgObject->getProportionalResize());
            if (($width = $imgObject->getWidth()) !== null) {
                $drawing->setWidth($width);
            }

            if (($height = $imgObject->getHeight()) !== null) {
                $drawing->setHeight($height);
            }

            $drawing->setWorksheet($phpSheet);
        }
    }

}
