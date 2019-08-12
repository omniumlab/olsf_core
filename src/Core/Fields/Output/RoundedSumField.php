<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 18/01/2018
 * Time: 17:26
 */

namespace Core\Fields\Output;


class RoundedSumField extends FunctionField
{

    /**
     * @var integer
     */
    private $round;

    public function __construct($name, $alias, $round = 2)
    {
        parent::__construct($name, $alias, "sum");
        $this->round = $round;
    }

    public function getSelectClause()
    {
        return "ROUND(" . $this->getFunctionName()."(" . $this->getName() . "), " . $this->round . ")";
    }
}