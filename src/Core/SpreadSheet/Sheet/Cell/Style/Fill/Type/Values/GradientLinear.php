<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Fill\Type\Values;


class GradientLinear implements FillTypeValueInterface
{

    function getValue(): string
    {
        return "fill_gradient_linear";
    }
}