<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Border\Type;

use Core\SpreadSheet\Sheet\Cell\Style\Border\Type\Values\BorderTypeValueInterface;
use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class BorderLeftType implements BorderLeftTypeInterface
{

    /** @var BorderTypeValueInterface */
    private $value;

    public function __construct(BorderTypeValueInterface $value = null)
    {
        if ($value !== null)
            $this->value = $value;
    }

    /**
     * @param Values\BorderTypeValueInterface $value
     * @return StyleInterface
     */
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
        return "BORDER_LEFT_TYPE";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}