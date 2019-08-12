<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 19:06
 */

namespace Core\Fields\Output;


use Core\Fields\BaseField;

class OutputFieldBase extends BaseField implements OutputFieldInterface
{
    public function __construct($name, $alias = null)
    {
        parent::__construct($name, $alias);
    }

    public function formatValue($value)
    {
        return $value;
    }

    /**
     * @return string
     */
    public function getSelectClause()
    {
        return $this->getName();
    }
}