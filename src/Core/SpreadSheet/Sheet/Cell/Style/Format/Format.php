<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Format;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\HorizontalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\Format\Values\FormatValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class Format implements FormatInterface
{
    /**
     * @var FormatValueInterface
     */
    private $value;

    public function __construct(FormatValueInterface $value = null)
    {
        if ($value !== null)
            $this->setValue($value);
    }

    /**
     * @param FormatValueInterface $value
     * @return StyleInterface
     */
    public function setValue($value): StyleInterface
    {
        $this->value = $value;
        return $this;
    }

    function getValue()
    {
        return $this->value;
    }

    function getName(): string
    {
        return "format";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}