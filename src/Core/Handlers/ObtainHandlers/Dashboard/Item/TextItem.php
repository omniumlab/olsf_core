<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/03/2018
 * Time: 10:42
 */

namespace Core\Handlers\ObtainHandlers\Dashboard\Item;


class TextItem extends Item
{
    /**
     * TextItem constructor.
     * @param null|string $name
     */

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setItemType("text");
    }

    /**
     * @param array $data [$columnName => value]
     */
    public function setData($data)
    {
        parent::setData($data);
    }


}