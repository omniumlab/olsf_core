<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 13/06/2019
 * Time: 13:00
 */

namespace Core\Handlers\ObtainHandlers\Dashboard\Item;


class ListItem extends Item
{
    public function __construct(string $entityName, $name = null)
    {
        parent::__construct($name);
        $this->setVariable("entityName", $entityName);
        $this->setItemType("list");
    }
}
