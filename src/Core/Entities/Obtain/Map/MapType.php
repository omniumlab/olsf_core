<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:47
 */

namespace Core\Entities\Obtain\Map;


use Core\Entities\EntityTypeBase;

class MapType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("map");
    }
}
