<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 15/02/2018
 * Time: 15:10
 */

namespace Core\Handlers\Filters\Propel;


use Core\Handlers\Filters\FilterInterface;
use Propel\Runtime\ActiveQuery\Criteria;

class Filter implements FilterInterface
{
    private $column;
    private $comparison;
    private $value;
    private $connector;

    /**
     * @var Filter[]
     */
    private $siblings = [];

    /**
     * Filter constructor.
     *
     * @param $column
     * @param $comparison
     * @param $value
     * @param $connector
     */
    public function __construct(
        $column,
        $value = null,
        $comparison = Criteria::LIKE,
        $connector = Criteria::LOGICAL_AND
    ) {
        $this->column = $column;
        $this->comparison = $comparison;
        $this->value = $value;
        $this->connector = $connector;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getComparison()
    {
        return $this->comparison;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getConnector()
    {
        return $this->connector;
    }

    public function add(Filter $filter)
    {
        $this->siblings[] = $filter;
    }

    public function getCriterion(Criteria $criteria)
    {
        $parentCriterion = $criteria->getNewCriterion($this->getColumn(), $this->getValue(), $this->getComparison());

        foreach ($this->siblings as $filter) {
            if ($filter->getConnector() === Criteria::LOGICAL_AND) {
                $parentCriterion->addAnd($filter->getCriterion($criteria));
            } else {
                $parentCriterion->addOr($filter->getCriterion($criteria));
            }
        }

        return $parentCriterion;
    }
}