<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 31/07/2017
 * Time: 18:38
 */

namespace Core\Handlers\ChangeHandlers\Propel;


use Core\Exceptions\NotFoundException;
use Core\Handlers\Filters\Propel\Filter;
use Core\Handlers\Filters\Propel\FilterManager;
use Core\Handlers\Filters\Propel\WhereableInterface;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Map\ColumnMap;
use Propel\Runtime\Map\Exception\ColumnNotFoundException;
use Propel\Runtime\Map\TableMap;

abstract class AbstractExistingDataHandler extends AbstractChangeHandler implements WhereableInterface
{
    protected $query;

    /** @var  FilterManager */
    private $filterManager;

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param string $method
     * @param bool $individual
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(ModelCriteria $query, string $method, bool $individual,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct($query->getTableMap(), null, $method, $individual, $textHandler);
        $this->filterManager = new FilterManager();
        $primary = $this->getPrimaryKey();

        if ($primary !== null)
            $this->removeField($primary->getFullyQualifiedName());

        $this->query = $query;
    }

    /**
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return ColumnMap
     */
    protected function getPrimaryKey()
    {
        $primaryKeys = $this->getTableMaps()[0]->getPrimaryKeys();

        assert(count($primaryKeys) < 2,
            $this->getTableMaps()[0]->getName() . " has more than one primary key. This is not supported");

        assert(count($primaryKeys) > 0, $this->getTableMaps()[0]->getName() . " must have a primary");

        return reset($primaryKeys);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Core\Exceptions\NotFoundException
     */
    protected function getByPrimary($id)
    {
        $query = clone $this->getQuery();
        $primary = $this->getPrimaryKey();

        $query->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
            ->filterBy($primary->getPhpName(), $id);

        $this->filterManager->addConditions($query);

        $object = $query->findOne();

        if ($object === null) {
            throw new NotFoundException();
        }

        return $object;
    }


    /**
     * Add a Filter to the filters.
     *
     * @param Filter $filter
     */
    function addFilter(Filter $filter)
    {
        $this->filterManager->addFilter($filter);
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
    function createFilter(
        ColumnMap $column,
        $value,
        $connector = Criteria::LOGICAL_AND,
        $comparison = Criteria::EQUAL,
        $addToFilters = true
    )
    {
        return $this->filterManager->createFilter($column, $value, $connector, $comparison, $addToFilters);
    }

    /**
     * Remove the filters by entering a name.
     *
     * @param $fieldName
     */
    function removeCondition($fieldName)
    {
        $this->filterManager->removeCondition($fieldName);
    }

    public function addAnd($column, $comparison = Criteria::LIKE, $value = null)
    {
        $this->createFilter($this->getColumn($column), $value, Criteria::LOGICAL_AND, $comparison);
    }

    public function addOr($column, $comparison = Criteria::LIKE, $value = null)
    {
        $this->createFilter($this->getColumn($column), $value, Criteria::LOGICAL_OR, $comparison);
    }

    /**
     * @param $name
     *
     * @return \Propel\Runtime\Map\ColumnMap
     * @throws ColumnNotFoundException
     */
    private function getColumn($name)
    {
        foreach ($this->getTableMaps() as $tableMap) {
            if ($tableMap->hasColumn($name)) {
                $column = $tableMap->getColumn($name);

                if ($column->getFullyQualifiedName() == $name) {
                    return $column;
                }
            }
        }

        throw new ColumnNotFoundException("Column " . $name . " does not exist in any joined table");
    }
}