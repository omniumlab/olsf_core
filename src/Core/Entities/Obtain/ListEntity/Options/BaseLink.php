<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/01/2018
 * Time: 9:38
 */

namespace Core\Entities\Obtain\ListEntity\Options;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class BaseLink implements ValueInterface
{

    /**
     * @var ListValueInterface Class Variables
     * "entityName" string
     * "foreignColumnName" string
     */
    private $variables;

    /**
     * BaseLink constructor.
     * @param $entityName string
     * @param $foreignColumnName string
     */
    public function __construct($entityName, $foreignColumnName)
    {
        $this->variables = new BaseListValue();
        $this->setEntityName($entityName);
        $this->setForeignColumnName($foreignColumnName);

    }

    /**
     * @param $entityName string
     */
    public function setEntityName($entityName){
        $this->variables->setValue($entityName, "entityName");
    }

    /**
     * @param $foreignColumnName string
     */
    public function setForeignColumnName($foreignColumnName){
        $this->variables->setValue($foreignColumnName, "foreignColumnName");
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}