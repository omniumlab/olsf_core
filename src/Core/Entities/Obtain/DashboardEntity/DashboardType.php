<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:18
 */

namespace Core\Entities\Obtain\DashboardEntity;


use Core\Entities\EntityTypeBase;

class DashboardType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("dashboard");
    }
}