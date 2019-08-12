<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:25
 */

namespace Core\Entities\Virtual\RestGoBackEntity;


use Core\Entities\EntityTypeBase;

class GoBackType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("go_back");
    }
}