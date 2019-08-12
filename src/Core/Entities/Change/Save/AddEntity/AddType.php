<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 21:42
 */

namespace Core\Entities\Change\Save\AddEntity;


use Core\Entities\EntityTypeBase;

class AddType extends EntityTypeBase
{
    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("add");
    }
}