<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Creator;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\HorizontalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\VerticalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\FillTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Format\FormatInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\FormatValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

interface StyleCreatorInterface
{

    /**
     * @return StyleCreatorInterface
     */
    function addAlignmentShrinkToFit(): StyleCreatorInterface;

    /**
     * @return StyleCreatorInterface
     */
    function addAlignmentWrapText(): StyleCreatorInterface;
    /**
     * @return StyleCreatorInterface
     */
    function addColumnAutoSizeAlignment(): StyleCreatorInterface;

    /**
     * @param FormatValueInterface $value
     * @return StyleCreatorInterface
     */
    function addFormatAlignment(FormatValueInterface $value): StyleCreatorInterface;
    /**
     * @param HorizontalAlignmentValueInterface $value
     * @return StyleCreatorInterface
     */
    function addHorizontalAlignment(HorizontalAlignmentValueInterface $value): StyleCreatorInterface;

    /**
     * @param VerticalAlignmentValueInterface $value
     * @return StyleCreatorInterface
     */
    function addVerticalAlignment(VerticalAlignmentValueInterface $value): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addBorderAllColor(string $color): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addBorderBottomColor(string $color): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addBorderLeftColor(string $color): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addBorderRightColor(string $color): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addBorderTopColor(string $color): StyleCreatorInterface;

    /**
     * @param BorderTypeValueInterface $value
     * @return StyleCreatorInterface
     */
    function addBorderAllType(BorderTypeValueInterface $value): StyleCreatorInterface;

    /**
     * @param BorderTypeValueInterface $value
     * @return StyleCreatorInterface
     */
    function addBorderTopType(BorderTypeValueInterface $value): StyleCreatorInterface;

    /**
     * @param BorderTypeValueInterface $value
     * @return StyleCreatorInterface
     */
    function addBorderBottomType(BorderTypeValueInterface $value): StyleCreatorInterface;

    /**
     * @param BorderTypeValueInterface $value
     * @return StyleCreatorInterface
     */
    function addBorderLeftType(BorderTypeValueInterface $value): StyleCreatorInterface;

    /**
     * @param BorderTypeValueInterface $value
     * @return StyleCreatorInterface
     */
    function addBorderRightType(BorderTypeValueInterface $value): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addFillStartColor(string $color): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addFillEndColor(string $color): StyleCreatorInterface;

    /**
     * @param FillTypeValueInterface $value
     * @return StyleCreatorInterface
     */
    function addFillType(FillTypeValueInterface $value): StyleCreatorInterface;

    /**
     * @return StyleCreatorInterface
     */
    function addFontBold(): StyleCreatorInterface;

    /**
     * @param string $color
     * @return StyleCreatorInterface
     */
    function addFontColor(string $color): StyleCreatorInterface;

    /**
     * @return StyleCreatorInterface
     */
    function addFontItalic(): StyleCreatorInterface;

    /**
     * @param $value
     * @return StyleCreatorInterface
     */
    function addFontSize($value): StyleCreatorInterface;

    /**
     * @return StyleCreatorInterface
     */
    function addFontUnderline(): StyleCreatorInterface;

    /**
     * @return StyleInterface[]
     */
    function getStyles(): array;

    /**
     * @return StyleCreatorInterface
     */
    function clear(): StyleCreatorInterface;
}