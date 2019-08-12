<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class GradientPath implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_gradient_path";
    }
}