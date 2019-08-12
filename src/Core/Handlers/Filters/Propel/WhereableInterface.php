<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 16/03/2018
 * Time: 11:44
 */

namespace Core\Handlers\Filters\Propel;


use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Map\ColumnMap;

interface WhereableInterface
{
    /**
     * Add a Filter to the filters.
     *
     * @param Filter $filter
     */
    function addFilter(Filter $filter);

    /**
     * Create a Filter.
     *
     * @param ColumnMap $column
     * @param mixed $value
     * @param string $connector
     * @param string $comparison
     * @param bool $addToFilters
     * @return Filter
     */
    function createFilter(ColumnMap $column, $value, $connector = Criteria::LOGICAL_AND, $comparison = Criteria::EQUAL, $addToFilters = true);

    /**
     * Add the filters created previously to the query.
     *
     * @return void
     */
    function addConditions();

    /**
     * Remove the filters by entering a name.
     *
     * @param $fieldName
     */
    function removeCondition($fieldName);
}