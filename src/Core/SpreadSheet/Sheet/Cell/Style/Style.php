<?php


namespace Core\SpreadSheet\Sheet\Cell\Style;


class Style implements StyleInterface
{
    /** @var string */
    private $name;

    /** @var mixed*/
    private $value;

    function setValue($value): StyleInterface
    {
        $this->value = $value;
        return $this;
    }

    function setName($value): StyleInterface
    {
        $this->name = $value;
        return $this;
    }

    function getValue()
    {
        return $this->value;
    }

    function getName(): string
    {
        return $this->name;
    }

}