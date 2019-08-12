<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:26
 */

namespace Core\Entities\Change\Save\UpdateEntity;


use Core\Entities\EntityTypeBase;

class UpdateType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("update");
    }
}