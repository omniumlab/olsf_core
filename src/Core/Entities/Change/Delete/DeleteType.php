<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:19
 */

namespace Core\Entities\Change\Delete;


use Core\Entities\EntityTypeBase;

class DeleteType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("delete");
    }
}