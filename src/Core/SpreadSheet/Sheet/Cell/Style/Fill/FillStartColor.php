<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FillStartColor implements StyleInterface
{

    /** @var string */
    private $value;

    public function __construct(string $value = null)
    {
        $this->setValue($value);
    }

    function setValue($value): StyleInterface
    {
        $this->value = $value;
        return $this;
    }

    function setName($value): StyleInterface
    {
        return $this;
    }

    function getValue()
    {
        return $this->value;
    }

    function getName(): string
    {
        return "fill_start_color";
    }
}