<?php


namespace Core\SpreadSheet\Sheet\Cell\Style\Font;


use Core\SpreadSheet\Sheet\Cell\Style\StyleInterface;

class FontColor implements StyleInterface
{

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value = null)
    {
        if ($value !== null)
            $this->setValue($value);
    }

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
        return "font_color";
    }

    function setName($value): StyleInterface
    {
        return $this;
    }
}