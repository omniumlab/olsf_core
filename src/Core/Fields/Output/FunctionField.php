<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/12/2017
 * Time: 18:00
 */

namespace Core\Fields\Output;


class FunctionField extends OutputFieldBase
{
    private $functionName;
    
    public function __construct($name, $alias, $functionName)
    {
        parent::__construct($name, $alias);
        $this->functionName = $functionName;
    }

    public function getSelectClause()
    {
        return $this->functionName."(" . $this->getName() . ")";
    }

    /**
     * @return mixed
     */
    public function getFunctionName()
    {
        return $this->functionName;
    }



}