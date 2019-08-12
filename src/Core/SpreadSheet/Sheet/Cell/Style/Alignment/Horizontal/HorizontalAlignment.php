<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal;

use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Horizontal\Values\HorizontalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class HorizontalAlignment implements HorizontalAlignmentInterface
{

    /**
     * @var HorizontalAlignmentValueInterface
     */
    private $value;

    public function __construct(HorizontalAlignmentValueInterface $value = null)
    {
        if ($value !== null)
            $this->setValue($value);
    }

    /**
     * @param HorizontalAlignmentValueInterface $value
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
        return "horizontal_alignment";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}