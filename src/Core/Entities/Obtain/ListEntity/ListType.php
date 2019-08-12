<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:24
 */

namespace Core\Entities\Obtain\ListEntity;


use Core\Entities\EntityTypeBase;

class ListType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("list");
    }
}