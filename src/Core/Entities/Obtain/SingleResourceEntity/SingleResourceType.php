<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/08/2018
 * Time: 11:06
 */

namespace Core\Entities\Obtain\SingleResourceEntity;


use Core\Entities\EntityTypeBase;

class SingleResourceType extends EntityTypeBase
{
    /**
     * SingleResourceType constructor.
     */
    public function __construct()
    {
        parent::__construct("single_resource");
    }
}