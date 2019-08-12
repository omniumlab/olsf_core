<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 17:50
 */

namespace Core\Handlers\ObtainHandlers\Propel;


use Core\Commands\ListHandlerCommandInterface;
use Core\Exceptions\RestException;
use Core\Fields\Output\Date;
use Core\Fields\Output\Enum;
use Core\Fields\Output\FunctionField;
use Core\Fields\Output\NumberFloat;
use Core\Fields\Output\NumberInteger;
use Core\Fields\Output\OutputFieldBase;
use Core\Fields\Output\OutputFieldInterface;
use Core\Fields\Output\RoundedAvgField;
use Core\Fields\Output\RoundedSumField;
use Core\Fields\Output\SymfonyTraducibleText;
use Core\Fields\Output\Text;
use Core\Fields\Output\Time;
use Core\Fields\Output\Timestamp;
use Core\Handlers\Filters\Propel\Filter;
use Core\Handlers\Filters\Propel\FilterManager;
use Core\Handlers\Filters\Propel\WhereableInterface;
use Core\Handlers\Handler;
use Core\Output\AutocompleteOutputObject;
use Core\Output\BaseOutputObject;
use Core\Output\HttpCodes;
use Core\Output\OutputObjectInterface;
use Core\Repository\Translation\SymfonyTranslationRepository;
use Core\Text\TextHandlerInterface;
use Propel\Generator\Model\PropelTypes;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Exception\UnknownColumnException;
use Propel\Runtime\ActiveQuery\Join;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\DataFetcher\PDODataFetcher;
use Propel\Runtime\Map\ColumnMap;
use Propel\Runtime\Map\Exception\ColumnNotFoundException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;

abstract class AbstractQueryHandler extends Handler implements QueryHandlerInterface, WhereableInterface
{

    const NO_LIMIT = -1;

    /**
     * @var ModelCriteria
     */
    private $query;

    /**
     * @var TableMap[]
     */
    private $tables = [];

    /**
     * @var OutputFieldInterface[]
     */
    private $fields = [];

    /**
     * @var int
     */
    private $count;

    /**
     * @var TableMap
     */
    private $lastJoinedTable;

    /**
     * @var PDODataFetcher
     */
    private $collection;

    /** @var  string */
    private $parentField;

    /** @var  int|null */
    private $manualLimit;

    /** @var  FilterManager */
    private $filterManager;
    /**
     * @var bool
     */
    private $autocomplete;
    /** @var SymfonyTranslationRepository */
    private $translateRepository;

    /**
     * @param ModelCriteria $query
     * @param TextHandlerInterface $textHandler
     * @param bool $individual
     */
    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandler, bool $individual = false)
    {
        parent::__construct("GET", $individual, $textHandler);
        $this->filterManager = new FilterManager();
        $this->query = $query;
        $this->query->setPrimaryTableName($query->getTableMap()->getName());
        $this->tables[] = $query->getTableMap();
        $this->lastJoinedTable = $query->getTableMap();
    }

    /**
     * @return \Propel\Runtime\Map\TableMap
     */
    public function getInitialTableMap()
    {
        return $this->tables[0];
    }

    /**
     * @param \Core\Commands\ListHandlerCommandInterface|null $command
     *
     * @return $this|QueryHandlerInterface
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function doListQuery(?ListHandlerCommandInterface $command)
    {
        $this->prepareQuery($command);

        if (!$command && !$this->manualLimit) {
            $this->getQuery()->setLimit(ListHandlerCommandInterface::DEFAULT_LIMIT);
        } else if ($this->manualLimit === null) {
            $this->getQuery()->setOffset($command->getOffset())->setLimit($command->getLimit());
        } else if ($this->manualLimit !== AbstractQueryHandler::NO_LIMIT) {
            $this->getQuery()->setLimit($this->manualLimit);
        }

        $this->collection = $this->getQuery()->doSelect();
        $this->collection->setStyle(\PDO::FETCH_ASSOC);

        $this->postListQuery($this->collection);

        return $this;
    }


    public function postListQuery(PDODataFetcher $collectionQuery)
    {

    }

    /**
     * Ejecuta el Query y devuelve la respuesta iterada.
     *
     * @param ListHandlerCommandInterface|null $command
     *
     * @return array
     */
    public function getAll(?ListHandlerCommandInterface $command = null)
    {
        $this->doListQuery($command);
        $array = [];
        while (($item = $this->next()) !== null) {
            $array[] = $item->toArray();
        }

        return $array;
    }

    /**
     * @param \Core\Commands\ListHandlerCommandInterface $command
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    private function prepareQuery(?ListHandlerCommandInterface $command)
    {
        $this->autocomplete = false;

        if ($command !== null) {
            $this->autocomplete = $command->autocomplete();
            $filters = $command->getFilters();
            $this->setFilters($filters);

            if ($this->autocomplete) {
                $this->replaceFieldsWithAutocomplete();
                $this->setFiltersAutocomplete($filters);
            }

            $this->setOrder($command->getSort());
        }

        $this->addFieldsToQuery();
        $this->customizeListQuery();
        $this->addConditions();
        $this->addDeletedAtCondition();
        $this->count = $this->doCount();
    }

    private function replaceFieldsWithAutocomplete()
    {
        foreach ($this->fields as $field) {
            if ($field instanceof SymfonyTraducibleText)
                $this->translateRepository = $field->translateRepository();
        }
        $this->fields = [];

        foreach ($this->tables as $table) {
            foreach ($table->getColumns() as $column) {
                if ($column->isPrimaryKey() || $column->isPrimaryString()) {
                    $this->createField($column->getFullyQualifiedName());
                }
            }
        }
    }

    private function addFieldsToQuery()
    {
        foreach ($this->getFields() as $field) {
            if ($this->columnExists($field->getName())) {
                $this->getQuery()->addAsColumn("'" . $field->getAlias() . "'", $field->getSelectClause());
            }
        }
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
     * @return mixed
     */
    private function doCount()
    {
        $criteria = clone $this->query;

        $count = $criteria->doCount();

        $count->next();

        return $count->current()[0];
    }

    public function customizeListQuery()
    {

    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria $query
     *
     * @return void
     */
    public function customizeListExternalQuery(Criteria $query)
    {

    }

    public function setLimit($limit)
    {
        $this->manualLimit = $limit;
    }

    protected function setOrder(array $sort)
    {
        if (empty($sort)) {
            return false;
        }

        try {
            switch ($sort[1]) {
                case Criteria::ASC:
                    $this->getQuery()->addAscendingOrderByColumn($sort[0]);

                    return true;
                case Criteria::DESC:
                    $this->getQuery()->addDescendingOrderByColumn($sort[0]);

                    return true;
            }
        } catch (UnknownColumnException $ex) {
            return false;
        }

        return false;
    }

    /**
     * @return bool True if at least one filter has been applied
     */
    private function setFilters(array $filters)
    {
        $applied = false;

        foreach ($filters as $columName => $value) {
            try {
                $column = $this->getColumn($columName);
                $traducible = $this->isTraducible($columName);
            } catch (\Exception $ex) {
                continue;
            }
            $applied = true;

            if ($traducible) {
                $field = $this->getFieldWithName($columName);
                if ($field instanceof SymfonyTraducibleText) {
                    $trans = $field->compareValues($value);
                    if (!empty($trans)) {
                        if ($field->isTranslateAllWords()) {
                            foreach ($trans as $word) {
                                $this->createFilter($column, $word);
                            }
                        } else
                            $this->createFilter($column, $trans);


                    } else
                        $this->createFilter($column, $value);
                }
            } else
                $this->createFilter($column, $value);
        }

        return $applied;
    }

    public function isTraducible($name): bool
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $name && $field instanceof SymfonyTraducibleText) {
                if ($field->isDefaultLang())
                    return false;
                return true;
            }
        }
        return false;
    }

    public function getFieldWithName($name): SymfonyTraducibleText
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $name && $field instanceof SymfonyTraducibleText)
                return $field;
        }
        return null;
    }

    private function setFiltersAutocomplete(array $filtersValues)
    {
        if (!isset($filtersValues["value"])) {
            return;
        }

        /** @var Filter $firstFilter */
        $firstFilter = null;

        foreach ($this->getFields() as $field) {

            $column = $this->getColumn($field->getName());

            if ($column->isPrimaryKey() || !$column->isPrimaryString()) {
                continue;
            }
            if ($field instanceof SymfonyTraducibleText && !$field->isDefaultLang()) {
                $trans = $field->compareValues($filtersValues["value"]);
                if (!empty($trans)) {
                    if ($field->isTranslateAllWords()) {
                        foreach ($trans as $word) {
                            $this->normalFilterAutocomplete($word, $firstFilter, $column);
                        }
                    } else
                        $this->normalFilterAutocomplete($trans, $firstFilter, $column);


                } else
                    $this->normalFilterAutocomplete($filtersValues["value"], $firstFilter, $column);
            } else {
                $this->normalFilterAutocomplete($filtersValues["value"], $firstFilter, $column);
            }
        }
    }

    /**
     * @return OutputFieldInterface[]
     */
    public function getFields(): array
    {
        if (empty($this->fields)) {
            $this->createAllFields();
        }

        return $this->fields;
    }

    public function removeField(string $fieldName)
    {
        foreach ($this->fields as $index => $field) {
            if ($field->getName() === $fieldName)
                unset($this->fields[$index]);
        }
    }

    private function createAllFields()
    {
        foreach ($this->tables as $table) {
            foreach ($table->getColumns() as $column) {
                if ($column->getName() !== "deleted_at")
                    $this->createField($column->getFullyQualifiedName());
            }
        }
    }

    /**
     * @return OutputObjectInterface|null Next object in the query. NULL if there is no more.
     */
    public function next()
    {
        $this->collection->next();

        if (!$this->collection->valid()) {
            return null;
        }

        $propelRowObject = $this->collection->current();
        $row = $this->createObject($propelRowObject);

        $this->postNext($row);

        return $row;
    }

    public function postNext(OutputObjectInterface $row)
    {

    }

    /**
     * @param $value
     *
     * @return OutputObjectInterface|null Object selected. NULL if the object cannot be found.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getByPrimary($value)
    {
        $primary = $this->getPrimaryKeyField();

        $this->createFilter($primary, $value);
        $this->doListQuery(null);

        return $this->next();
    }

    /**
     * @param $primaryKeys
     *
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getByPrimaryKeys($primaryKeys)
    {
        $result = [];

        $this->prepareQuery(null);

        $pk = $this->getPrimaryKeyField();
        $this->getQuery()->add($pk->getFullyQualifiedName(), $primaryKeys, Criteria::IN);

        $this->doListQuery(null);

        while (($item = $this->next()) !== null) {
            $result[] = $item->toArray();
        }

        return $result;
    }

    private function getPrimaryKeyField()
    {
        $primaryKeys = $this->getInitialTableMap()->getPrimaryKeys();

        assert(count($primaryKeys) < 2,
            $this->getInitialTableMap()->getName() . " has more than one primary key. This is not supported");
        assert(count($primaryKeys) > 0, $this->getInitialTableMap()->getName() . " must have a primary");

        $primary = reset($primaryKeys);

        return $primary;
    }

    /**
     * @param string $name Name of the field (table.field_name)
     *
     * @param array $values
     *
     * @param string $alias
     *
     * @return OutputFieldInterface Field created
     *
     */
    public function createField($name, $alias = null, $values = [])
    {
        $column = $this->getColumn($name);

        $field = new OutputFieldBase($name, $alias);

        switch ($column->getType()) {
            case PropelTypes::BOOLEAN:
                break;
            case PropelTypes::INTEGER:
            case PropelTypes::BIGINT:
                $field = new NumberInteger($name, $alias);
                break;
            case PropelTypes::DECIMAL:
            case PropelTypes::FLOAT:
            case PropelTypes::DOUBLE:
                $field = new NumberFloat($name, $alias);
                break;
            case PropelTypes::VARCHAR:
            case PropelTypes::LONGVARCHAR:
                if ($this->translateRepository !== null)
                    $field = new SymfonyTraducibleText($name, $this->translateRepository, $alias);
                else
                    $field = new Text($name, $alias);

                break;
            case PropelTypes::ENUM:
                $field = new Enum($name, $column->getValueSet(), $alias);

                if (!empty($values)) {
                    $field->setValues($values);
                }
                break;
            case PropelTypes::TIMESTAMP:
                $field = new Timestamp($name, $alias);
                break;
            case PropelTypes::DATE:
                $field = new Date($name, $alias);
                break;
            case PropelTypes::TIME:
                $field = new Time($name, $alias);
                break;
        }

        $field->setRequired($column->isNotNull());
        $field->setType($column->getType());
        $field->setPrimaryKey($column->isPrimaryKey());

        $this->addField($field);

        return $field;
    }

    private function columnExists($name): bool
    {
        try {
            $this->getColumn($name);

            return true;
        } catch (ColumnNotFoundException $ex) {
            return false;
        }
    }

    /**
     * @param $name
     *
     * @return \Propel\Runtime\Map\ColumnMap
     * @throws ColumnNotFoundException
     */
    public function getColumn($name)
    {
        foreach ($this->tables as $tableMap) {
            if ($tableMap->hasColumn($name)) {
                $column = $tableMap->getColumn($name);

                if ($column->getFullyQualifiedName() == $name || $this->autocomplete) {
                    return $column;
                }
            }
        }

        foreach ($this->fields as $field) {
            if ($field->getAlias() === $name && $field->getName() !== $name) {
                return $this->getColumn($field->getName());
            }
        }

        throw new ColumnNotFoundException("Column " . $name . " does not exist in any joined table");
    }

    public function addField(OutputFieldInterface $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @param ModelCriteria $foreignQuery
     * @param string|ColumnMap $localField Can be a string (full name) if the "left" part of the join is is the
     *                                       initial table. If the "left" part of the join is another table, this must
     *                                       be a ColumnMap
     * @param string $foreignField Full Name of the foreign
     *
     * @return static
     */
    public function leftJoin(ModelCriteria $foreignQuery, $localField = null, $foreignField = null)
    {
        return $this->addJoin(Criteria::LEFT_JOIN, $foreignQuery, $localField, $foreignField);
    }

    /**
     * @param ModelCriteria $foreignQuery
     * @param string|ColumnMap $localField Can be a string (full name) if the "left" part of the join is is the
     *                                       initial table. If the "left" part of the join is another table, this must
     *                                       be a ColumnMap
     * @param string $foreignField Full Name of the foreign
     *
     * @return static
     */
    public function join(ModelCriteria $foreignQuery, $localField = null, $foreignField = null)
    {
        return $this->addJoin(Criteria::INNER_JOIN, $foreignQuery, $localField, $foreignField);
    }

    /**
     * @param string $type Type of the join with the values of propel constants Criteria::*_JOIN
     * @param ModelCriteria $foreignQuery
     * @param string|array $localField Full column name for the "left" part of the join.
     * @param string|array $foreignField Full column name for the "right" part of the join.
     *
     * @return static
     * @throws ColumnNotFoundException If the $localField or $foreignField were not found in any joined table (or in
     *                                 the initial one)
     */
    private function addJoin($type, ModelCriteria $foreignQuery, $localField = null, $foreignField = null)
    {
        if ($localField === null) {
            return $this->addJoinWithForeign($type, $foreignQuery);
        }

        $foreignTable = $foreignQuery->getTableMap();
        $this->tables[] = $foreignTable;

        if ($foreignField === null) {
            if (is_array($localField)) {
                throw new \LogicException("For multifield foreign keys you cannot set \$foreignField to NULL");
            }

            $localColumn = $this->getColumn($localField);
            $foreignField = $localColumn->getRelatedColumn()->getFullyQualifiedName();
        } else if (is_object($foreignField)) {
            $foreignField = $foreignTable->getColumn($foreignField)->getFullyQualifiedName();
        }

        $this->lastJoinedTable = $foreignTable;
        $this->getQuery()->addJoin($localField, $foreignField, $type);

        return $this;
    }

    public function addJoinObject(Join $join, TableMap $table)
    {
        $this->tables[] = $table;
        $this->getQuery()->addJoinObject($join);
    }

    /**
     * Returns the last joined table or the initial table if there is no joined table yet.
     *
     * @return \Propel\Runtime\Map\TableMap
     */
    private function getLastJoinedTable()
    {
        return $this->lastJoinedTable;
    }

    /**
     * @param $type
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $foreignQuery
     *
     * @return \Core\Handlers\ObtainHandlers\Propel\AbstractQueryHandler
     */
    private function addJoinWithForeign($type, ModelCriteria $foreignQuery)
    {
        $localTableMap = $this->getLastJoinedTable();
        $foreignTableMap = $foreignQuery->getTableMap();

        $localColumns = [];
        $foreignColumns = [];
        foreach ($localTableMap->getRelations() as $relation) {
            if ($this->isRelation($relation, $localTableMap, $foreignTableMap, false)) {

                if (count($localColumns) == 1) {
                    throw new \LogicException("Found more than one relation between " . $localTableMap->getName() . " and " . $foreignTableMap->getName());
                }

                if ($this->isRelation($relation, $foreignTableMap, $localTableMap, true)) {
                    $localColumns = $this->getColumnNames($relation->getForeignColumns());
                    $foreignColumns = $this->getColumnNames($relation->getLocalColumns());
                } else {
                    $localColumns = $this->getColumnNames($relation->getLocalColumns());
                    $foreignColumns = $this->getColumnNames($relation->getForeignColumns());
                }
            }
        }

        if (count($localColumns) == 0) {
            throw new \LogicException("No relation not found between " . $localTableMap->getName() . " and " . $foreignTableMap->getName());
        }

        return $this->addJoin($type, $foreignQuery, $localColumns, $foreignColumns);
    }

    /**
     * @param \Propel\Runtime\Map\RelationMap $relation
     * @param \Propel\Runtime\Map\TableMap $localTableMap
     * @param \Propel\Runtime\Map\TableMap $foreignTableMap
     * @param bool $strict True si queremos comprobar la tabla local como local y la foránea como foranea. Si se
     *     establece a false, se comprueba también a la inversa
     *
     * @return bool
     */
    private function isRelation(RelationMap $relation, TableMap $localTableMap, TableMap $foreignTableMap, bool $strict)
    {
        $localTableName = $relation->getLocalTable()->getName();
        $foreignTableName = $relation->getForeignTable()->getName();

        if ($localTableName == $localTableMap->getName() && $foreignTableName == $foreignTableMap->getName()) {
            return true;
        }

        if (!$strict) {
            return $foreignTableName == $localTableMap->getName() && $localTableName == $foreignTableMap->getName();
        }

        return false;
    }

    /**
     * @param ColumnMap[] $columnMaps
     *
     * @return string[]
     */
    private function getColumnNames(array $columnMaps): array
    {
        $result = [];
        foreach ($columnMaps as $columnMap) {
            $result[] = $columnMap->getFullyQualifiedName();
        }

        return $result;
    }

    /**
     * @param mixed $propelRowObject
     *
     * @return BaseOutputObject
     *
     */
    public function createObject($propelRowObject)
    {
        if (!is_array($propelRowObject)) {
            assert(method_exists($propelRowObject, "toArray"), get_class($propelRowObject) . "::toArray() not found");
            $rawData = $propelRowObject->toArray(TableMap::TYPE_COLNAME, true, [], true);
        } else {
            $rawData = $propelRowObject;
        }

        if ($this->autocomplete) {
            return new AutocompleteOutputObject($this->getFields(), $rawData);
        }

        return new BaseOutputObject($this->getFields(), $rawData);
    }

    /**
     * @param                                           $localField
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     *
     * @return \Core\Handlers\ObtainHandlers\Propel\AbstractQueryHandler
     * @throws \Exception
     * @deprecated Use join or leftJoin instead
     */
    public function addForeignQueryHandler($localField, ModelCriteria $query)
    {
        return $this->leftJoin($query, $localField);
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Do a group by for the specified field
     *
     * @param string $fieldName Full name of the field.
     *
     * @return static
     */
    public function groupBy($fieldName)
    {
        $this->getQuery()->addGroupByColumn($fieldName);

        return $this;
    }

    /**
     * @param string $field
     * @param null|string $value
     * @param null|string $comparison
     *
     * @return $this
     */
    public function having(string $field, ?string $value = null, ?string $comparison = null)
    {
        $this->getQuery()->addHaving($field, $value, $comparison);

        return $this;
    }

    /**
     * Adds a group of fields to the Select clause. The order will be kept.
     *
     * @param string[] $fieldsNames Array with the name of the fields to add in the order required
     */
    public function createFields(array $fieldsNames)
    {
        foreach ($fieldsNames as $fieldName) {
            $this->createField($fieldName);
        }
    }


    /**
     * Adds a field counting by an existing field
     *
     * @param string $fieldName Field to count for.
     * @param string $alias Alias for this field
     *
     * @return static
     */
    public function addCountField($fieldName, $alias)
    {
        $this->addField(new FunctionField($fieldName, $alias, "count"));

        return $this;
    }

    /**
     * Adds a field making a sum of an existing field
     *
     * @param string $fieldName Field to do the sum.
     * @param string $alias Alias for this field
     *
     * @return static
     */
    public function addSumField($fieldName, $alias)
    {
        $this->addField(new RoundedSumField($fieldName, $alias));

        return $this;
    }

    /**
     * Adds a field making the average of an existing field
     *
     * @param string $fieldName Field to do the average.
     * @param string $alias Alias for this field
     *
     * @return static
     */
    public function addAverageField($fieldName, $alias)
    {
        $this->addField(new RoundedAvgField($fieldName, $alias));

        return $this;
    }

    /**
     * Adds a field getting the min value of an existing field
     *
     * @param string $fieldName Field to do the min.
     * @param string $alias Alias for this field
     *
     * @return static
     */
    public function addMinField($fieldName, $alias)
    {
        $this->addField(new FunctionField($fieldName, $alias, "min"));

        return $this;
    }

    /**
     * Adds a field getting the max value of an existing field
     *
     * @param string $fieldName Field to do the max.
     * @param string $alias Alias for this field
     *
     * @return static
     */
    public function addMaxField($fieldName, $alias)
    {
        $this->addField(new FunctionField($fieldName, $alias, "max"));

        return $this;
    }

    /**
     * Adds a field getting the hour value of an existing field
     *
     * @param string $fieldName Field to do the hour.
     * @param string $alias Alias for this field
     *
     * @return static
     */
    public function addHourField($fieldName, $alias)
    {
        $this->addField(new FunctionField($fieldName, $alias, "hour"));

        return $this;
    }

    public function setIdParent($id)
    {
        if ($this->parentField === null) {
            throw new RestException(HttpCodes::CODE_INTERNAL_SERVER_ERROR,
                $this->getTextHandler()->get("failure_parent_field"));
        }

        $this->addAnd($this->parentField, Criteria::EQUAL, $id);
    }


    /**
     * @return mixed
     */
    public function getParentField()
    {
        return $this->parentField;
    }


    public function setParentField($parentField)
    {
        $this->parentField = $parentField;
    }

    function addFilter(Filter $filter)
    {
        $this->filterManager->addFilter($filter);
    }

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

    function addConditions()
    {
        $this->filterManager->addConditions($this->getQuery());
    }

    private function addDeletedAtCondition()
    {
        $tableMap = $this->query->getTableMap();

        if ($tableMap->hasColumn("deleted_at"))
            $this->query->addAnd($tableMap->getName() . ".deleted_at", null, Criteria::ISNULL);
    }

    function removeCondition($fieldName)
    {
        $this->filterManager->removeCondition($fieldName);
    }

    /**
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function getQuery(): ModelCriteria
    {
        return $this->query;
    }

    /**
     * @param array $filtersValues
     * @param $firstFilter
     * @param $column
     */
    private function normalFilterAutocomplete($filtersValues, &$firstFilter, $column): void
    {
        if ($firstFilter === null) {
            $firstFilter = $this->createFilter($column, $filtersValues, Criteria::LOGICAL_AND);
        } else {
            $firstFilter->add($this->createFilter($column, $filtersValues, Criteria::LOGICAL_OR,
                Criteria::EQUAL, false));
        }
    }
}
