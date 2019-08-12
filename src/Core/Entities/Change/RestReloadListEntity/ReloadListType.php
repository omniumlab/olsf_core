<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:25
 */

namespace Core\Entities\Change\RestReloadListEntity;


use Core\Entities\EntityTypeBase;

class ReloadListType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("reload_list");
    }
}