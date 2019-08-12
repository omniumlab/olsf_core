<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Format\Values;


class Time implements FormatValueInterface
{

    function getValue(): string
    {
        return "format_time";
    }
}