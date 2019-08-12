<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:20
 */

namespace Core\Entities\Obtain\DetailEntity;


use Core\Entities\EntityTypeBase;

class DetailType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("detail");
    }
}