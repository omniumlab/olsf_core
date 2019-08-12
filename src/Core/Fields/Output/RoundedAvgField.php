<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 19/01/2018
 * Time: 12:16
 */

namespace Core\Fields\Output;


class RoundedAvgField extends FunctionField
{
    /**
     * @var integer
     */
    private $round;

    public function __construct($name, $alias, $round = 2)
    {
        parent::__construct($name, $alias, "avg");
        $this->round = $round;
    }

    public function getSelectClause()
    {
        return "ROUND(" . $this->getFunctionName()."(" . $this->getName() . "), " . $this->round . ")";
    }
}