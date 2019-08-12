<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/03/2018
 * Time: 10:00
 */

namespace Core\Handlers\ObtainHandlers\Dashboard;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;
use Core\Handlers\ObtainHandlers\Dashboard\Item\Item;

class Group implements ValueInterface
{

    /**
     * @var ListValueInterface Class Variables
     * "columns" int
     * "items" Item[]
     */
    private $variables;

    public function __construct($columns = 1)
    {
        $this->variables = new BaseListValue();
        $this->setColumns($columns);
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item){
        $this->variables->addItemToArray("items", $item);

        return $this;
    }

    /**
     * @param int $columns
     */
    public function setColumns($columns)
    {
        $this->variables->setValue($columns, "columns");
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}