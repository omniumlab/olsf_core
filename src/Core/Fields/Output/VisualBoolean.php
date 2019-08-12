<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/01/2018
 * Time: 16:59
 */

namespace Core\Fields\Output;


use Core\Text\TextHandlerInterface;

class VisualBoolean extends OutputFieldBase
{

    /** @var TextHandlerInterface */
    private $textHandler;

    public function __construct($name, TextHandlerInterface $textHandler, $alias = null)
    {
        parent::__construct($name, $alias);
        $this->textHandler = $textHandler;
    }

    public function formatValue($value)
    {
        return $value === 1? $this->textHandler->get("yes") : $this->textHandler->get("no");
    }
}
