<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 16/03/2018
 * Time: 11:23
 */

namespace Core\Handlers\Filters\Propel;


use Propel\Generator\Model\PropelTypes;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Map\ColumnMap;

class FilterManager
{
    /**
     * @var Filter[]
     */
    private $filters = [];


    /**
     * Add a Filter to the filters.
     *
     * @param Filter $filter
     */
    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Create a Filter.
     *
     * @param ColumnMap $column
     * @param mixed $value
     * @param string $connector
     * @param string $comparison
     * @param bool $addToFilters
     *
     * @return Filter
     */
    public function createFilter(
        ColumnMap $column,
        $value,
        $connector = Criteria::LOGICAL_AND,
        $comparison = Criteria::EQUAL,
        $addToFilters = true
    ) {
        if (is_array($value)) {
            $comparison = $comparison === Criteria::NOT_IN ? Criteria::NOT_IN : Criteria::IN;
        } else if ($column->isText() && $comparison !== Criteria::NOT_EQUAL) {
            $comparison = Criteria::LIKE;
            $value = "%" . $value . "%";
        }

        switch ($column->getType()) {
            case PropelTypes::TIMESTAMP:
            case PropelTypes::DATE:
                $filter = $this->getTimeFilters($column, $value, $comparison, $connector);
                break;
            default:
                $filter = new Filter($column->getFullyQualifiedName(), $value, $comparison, $connector);
                break;
        }

        if ($addToFilters) {
            $this->filters[] = $filter;
        }

        return $filter;
    }

    /**
     * Add the date filters to the propel query. Dates must follow the following format: YYYYMMDD-YYYYMMDD or YYYYMMDD
     *
     * @param ColumnMap $column
     * @param mixed $value
     * @param string $comparison
     * @param string $connector
     *
     * @return Filter
     */
    private function getTimeFilters(ColumnMap $column, $value, $comparison, $connector)
    {
        switch ($comparison) {
            case Criteria::GREATER_THAN:
            case Criteria::GREATER_EQUAL:
            case Criteria::LESS_THAN:
            case Criteria::LESS_EQUAL:
            case Criteria::ISNULL:
            case Criteria::ISNOTNULL:
            case Criteria::CUSTOM:
                $filter = new Filter($column->getFullyQualifiedName(), $value, $comparison, $connector);
                break;
            default:
                $dates = explode("-", $value);

                if (count($dates) == 1) {
                    $dates[1] = $dates[0];
                }

                $startDate = $this->getFormattedDateString($dates[0], "00:00:00");
                $endDate = $this->getFormattedDateString($dates[1], "23:59:59");

                $filter = new Filter($column->getFullyQualifiedName(), $startDate, Criteria::GREATER_EQUAL);
                $filter->add(new Filter($column->getFullyQualifiedName(), $endDate, Criteria::LESS_EQUAL));
                break;
        }

        return $filter;
    }

    /**
     * @param        $rawString   string
     *
     * @param string $defaultTime Default time if the date hasn't any. Format: "HH:mm:ss"
     *
     * @return string
     */
    private function getFormattedDateString($rawString, $defaultTime)
    {
        $day = substr($rawString, 6, 2);
        $month = substr($rawString, 4, 2);
        $year = substr($rawString, 0, 4);

        $formattedString = $year . "-" . $month . "-" . $day;

        if (strlen($rawString) > 8) {
            $hours = substr($rawString, 8, 2);
            $minutes = substr($rawString, 10, 2);
            $formattedString .= " " . $hours . ":" . $minutes . ":00";
        } else {
            $formattedString .= " " . $defaultTime;
        }

        return $formattedString;
    }

    /**
     * Add the filters created previously to the query.
     *
     * @param Criteria $query
     */
    public function addConditions(Criteria $query)
    {
        foreach ($this->filters as $filter) {
            if ($filter->getConnector() == Criteria::LOGICAL_AND) {
                $query->addAnd($filter->getCriterion($query), false);
            } else {
                $query->addOr($filter->getCriterion($query), false);
            }
        }
    }

    /**
     * Remove the filters by entering a name.
     *
     * @param $fieldName
     */
    public function removeCondition($fieldName)
    {
        foreach ($this->filters as $filter) {
            if ($filter->getColumn() === $fieldName) {
                unset($filter, $this->filters);
            }
        }
    }
}
