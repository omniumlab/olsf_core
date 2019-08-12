<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Format\Values;


class Percentage implements FormatValueInterface
{

    function getValue(): string
    {
        return "format_percentage";
    }
}