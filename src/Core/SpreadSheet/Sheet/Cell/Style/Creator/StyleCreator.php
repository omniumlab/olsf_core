<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Creator;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\ColumnAutoSizeAlignment;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\HorizontalAlignmentInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\HorizontalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\ShrinkToFitAlignment;
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
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\FillEndColor;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\FillStartColor;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\FillTypeInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\FillTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontBold;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontColor;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontItalic;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontSize;
use Core\SpreadSheet\Sheet\Cell\Style\Font\FontUnderline;
use Core\SpreadSheet\Sheet\Cell\Style\Format\FormatInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\FormatValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class StyleCreator implements StyleCreatorInterface
{

    /** @var StyleInterface[] */
    private $styles = [];
    /**
     * @var HorizontalAlignmentInterface
     */
    private $horizontalAlignment;
    /**
     * @var VerticalAlignmentInterface
     */
    private $verticalAlignment;
    /**
     * @var BorderAllTypeInterface
     */
    private $borderAllType;
    /**
     * @var BorderLeftTypeInterface
     */
    private $borderLeftType;
    /**
     * @var BorderRightTypeInterface
     */
    private $borderRightType;
    /**
     * @var BorderTopTypeInterface
     */
    private $borderTopType;
    /**
     * @var BorderBottomTypeInterface
     */
    private $borderBottomType;
    /**
     * @var FillTypeInterface
     */
    private $fillType;
    /**
     * @var FormatInterface
     */
    private $cellFormat;

    public function __construct(HorizontalAlignmentInterface $horizontalAlignment, VerticalAlignmentInterface $verticalAlignment,
                                BorderAllTypeInterface $borderAllType, BorderLeftTypeInterface $borderLeftType,
                                BorderRightTypeInterface $borderRightType, BorderTopTypeInterface $borderTopType,
                                BorderBottomTypeInterface $borderBottomType, FillTypeInterface $fillType, FormatInterface $format)
    {
        $this->horizontalAlignment = $horizontalAlignment;
        $this->verticalAlignment = $verticalAlignment;
        $this->borderAllType = $borderAllType;
        $this->borderLeftType = $borderLeftType;
        $this->borderRightType = $borderRightType;
        $this->borderTopType = $borderTopType;
        $this->borderBottomType = $borderBottomType;
        $this->cellFormat=$format;
        $this->fillType = $fillType;
    }

    function addAlignmentShrinkToFit(): StyleCreatorInterface
    {
        return $this->addStyle(new ShrinkToFitAlignment());
    }

    function addAlignmentWrapText(): StyleCreatorInterface
    {
        return $this->addStyle(new WrapTextAlignment());
    }

    function addHorizontalAlignment(HorizontalAlignmentValueInterface $value): StyleCreatorInterface
    {
        $this->horizontalAlignment->setValue($value);
        return $this->addStyle($this->horizontalAlignment);
    }

    function addVerticalAlignment(VerticalAlignmentValueInterface $value): StyleCreatorInterface
    {
        $this->verticalAlignment->setValue($value);
        return $this->addStyle($this->verticalAlignment);
    }

    function addBorderAllColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new BorderAllColor($color));
    }

    function addBorderBottomColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new BorderBottomColor($color));
    }

    function addBorderLeftColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new BorderLeftColor($color));
    }

    function addBorderRightColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new BorderRightColor($color));
    }

    function addBorderTopColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new BorderTopColor($color));
    }

    function addBorderAllType(BorderTypeValueInterface $value): StyleCreatorInterface
    {
        $this->borderAllType->setValue($value);
        return $this->addStyle($this->borderAllType);
    }

    function addBorderTopType(BorderTypeValueInterface $value): StyleCreatorInterface
    {
        $this->borderTopType->setValue($value);
        return $this->addStyle($this->borderTopType);
    }

    function addBorderBottomType(BorderTypeValueInterface $value): StyleCreatorInterface
    {
        $this->borderBottomType->setValue($value);
        return $this->addStyle($this->borderBottomType);
    }

    function addBorderLeftType(BorderTypeValueInterface $value): StyleCreatorInterface
    {
        $this->borderLeftType->setValue($value);
        return $this->addStyle($this->borderLeftType);
    }

    function addBorderRightType(BorderTypeValueInterface $value): StyleCreatorInterface
    {
        $this->borderRightType->setValue($value);
        return $this->addStyle($this->borderRightType);
    }

    function addFillStartColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new FillStartColor($color));
    }

    function addFillEndColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new FillEndColor($color));
    }

    function addFillType(FillTypeValueInterface $value): StyleCreatorInterface
    {
        $this->fillType->setValue($value);
        return $this->addStyle($this->fillType);
    }

    function addFontBold(): StyleCreatorInterface
    {
        return $this->addStyle(new FontBold());
    }

    function addFontColor(string $color): StyleCreatorInterface
    {
        return $this->addStyle(new FontColor($color));
    }

    function addFontItalic(): StyleCreatorInterface
    {
        return $this->addStyle(new FontItalic());
    }

    function addFontSize($value): StyleCreatorInterface
    {
        return $this->addStyle(new FontSize($value));
    }

    function addFontUnderline(): StyleCreatorInterface
    {
        return $this->addStyle(new FontUnderline());
    }

    function getStyles(): array
    {
        return $this->styles;
    }

    function clear(): StyleCreatorInterface
    {
        unset($this->styles);
        $this->styles = [];
        return $this;
    }


    private function addStyle(StyleInterface $style): StyleCreatorInterface
    {
        array_push($this->styles, $style);
        return $this;
    }

    /**
     * @return StyleCreatorInterface
     */
    function addColumnAutoSizeAlignment(): StyleCreatorInterface
    {
        return $this->addStyle(new ColumnAutoSizeAlignment());

    }

    function addFormatAlignment(FormatValueInterface $value): StyleCreatorInterface
    {
        $this->cellFormat->setValue($value);
        return $this->addStyle($this->cellFormat);

    }


}