<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type;


use Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values\FillTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FillType implements FillTypeInterface
{
    /** @var FillTypeValueInterface */
    private $value;

    public function __construct(FillTypeValueInterface $value = null)
    {
        if ($value !== null)
            $this->setValue($value);
    }

    /**
     * @param FillTypeValueInterface $value
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
        return "fill_type";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}