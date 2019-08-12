<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Alignment;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class ColumnAutoSizeAlignment implements StyleInterface
{

    function getName(): string
    {
       return "column_auto_size_alignment";
    }

    /**
     * @return mixed
     */
    function getValue()
    {
        return true;
    }

    /**
     * @param mixed $value
     * @return StyleInterface
     */
    function setValue($value): StyleInterface
    {
        return $this;
    }

    function setName($value): StyleInterface
    {
        return $this;

    }
}