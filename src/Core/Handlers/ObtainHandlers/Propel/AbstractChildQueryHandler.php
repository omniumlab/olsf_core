<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 17/11/2017
 * Time: 17:02
 */

namespace Core\Handlers\ObtainHandlers\Propel;


use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Map\TableMap;

abstract class AbstractChildQueryHandler extends AbstractQueryHandler implements QueryHandlerInterface
{
    /**
     * @var TableMap
     */
    private $parentTableMap;
    /**
     * @var string
     */
    private $parentField;

    /**
     * @var mixed
     */
    private $idParent;

    /**
     * ChildQueryHandler constructor.
     *
     * @param TableMap $tableMap
     * @param TableMap $parentTableMap
     * @param ModelCriteria $query
     * @param bool $individual
     * @param TextHandlerInterface $textHandle
     */
    public function __construct(TableMap $tableMap, TableMap $parentTableMap, ModelCriteria $query, bool $individual, TextHandlerInterface $textHandle)
    {
        $this->parentField = $this->getFirstForeignKey($parentTableMap);
        $this->parentTableMap = $parentTableMap;

        parent::__construct($query, $textHandle, $individual);
    }

    public function customizeListQuery()
    {
        $relatedName = $this->parentTableMap->getPhpName();
        $relation = $this->getQuery()->getModelShortName() . "." . $relatedName;

        $this->getQuery()->leftJoin($relation)->where($this->parentField . " = ?", $this->idParent);
    }

    /**
     * @param $idParent mixed
     */
    public function setIdParent($idParent)
    {
        $this->idParent = $idParent;
    }

    /**
     * @param string $parentField
     */
    public function setParentField($parentField)
    {
        $this->parentField = $parentField;
    }


    /**
     * @param TableMap $tableMap
     *
     * @return string
     */
    private function getFirstForeignKey(TableMap $tableMap)
    {
        return $tableMap->getName() . "." . key($tableMap->getForeignKeys());
    }


}