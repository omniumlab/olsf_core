<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/07/2017
 * Time: 16:35
 */

namespace Core\Handlers\ObtainHandlers\Propel;


use Core\Commands\ListHandlerCommandInterface;
use Core\Fields\Output\OutputFieldInterface;
use Core\Handlers\HandlerInterface;
use Core\Output\OutputObjectInterface;
use Propel\Runtime\ActiveQuery\Criteria;

interface QueryHandlerInterface extends HandlerInterface
{
    /**
     *
     * @return $this|QueryHandlerInterface
     */
    public function doListQuery(ListHandlerCommandInterface $command);

    /**
     * @return OutputObjectInterface|null Next object in the query. NULL if there is no more.
     */
    public function next();

    /**
     * @param $value
     *
     * @return OutputObjectInterface|null Object selected. NULL if the object cannot be found.
     */
    public function getByPrimary($value);

    /**
     * @return int
     */
    public function getCount();

    /**
     * @return OutputFieldInterface[]
     */
    public function getFields();

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
    public function createField($name, $alias = null, $values = []);

    /**
     * @param string $column
     * @param string $comparison
     * @param null|mixed $value
     */
    public function addAnd($column, $comparison = Criteria::LIKE, $value = null);

    /**
     * @param string $column
     * @param string $comparison
     * @param null|mixed $value
     */
    public function addOr($column, $comparison = Criteria::LIKE, $value = null);

    /**
     * @param mixed $id
     */
    public function setIdParent($id);

    /**
     * @return mixed
     */
    public function getParentField();

    public function setParentField($parentField);
}