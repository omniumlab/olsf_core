<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical;


use Core\SpreadSheet\Sheet\Cell\Style\Alignment\Vertical\Values\VerticalAlignmentValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class VerticalAlignment implements VerticalAlignmentInterface
{

    /** @var VerticalAlignmentValueInterface */
    private $value;

    public function __construct(VerticalAlignmentValueInterface $value = null)
    {
        if ($value !== null)
            $this->setValue($value);
    }

    /**
     * @param VerticalAlignmentValueInterface $value
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
        return "vertical_alignment";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }

}