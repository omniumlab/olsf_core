<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Format\Values;


class Number implements FormatValueInterface
{

    function getValue(): string
    {
        return "format_number";
    }
}