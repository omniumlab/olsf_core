<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Color;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class BorderTopColor implements StyleInterface
{

    /** @var string */
    private $value;

    public function __construct(string $value = null)
    {
        $this->value = $value;
    }

    function setValue($value): StyleInterface
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
        return "BORDER_TOP_COLOR";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}