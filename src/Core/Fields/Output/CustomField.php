<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 03/09/2018
 * Time: 9:26
 */

namespace Core\Fields\Output;


class CustomField extends OutputFieldBase
{
    private $selectClause;

    public function __construct($name, $selectClause, $alias)
    {
        parent::__construct($name, $alias);
        $this->selectClause = $selectClause;
    }

    public function getSelectClause()
    {
        return $this->selectClause;
    }
}