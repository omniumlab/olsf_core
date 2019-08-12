<?php


namespace Core\SpreadSheet\Sheet\Cell\Style;


interface StyleInterface
{

    function getName(): string;

    /**
     * @return mixed
     */
    function getValue();

    /**
     * @param mixed $value
     * @return StyleInterface
     */
    function setValue($value): StyleInterface;

    function setName($value): StyleInterface;
}