<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/04/2019
 * Time: 10:14
 */

namespace Core\Entities\Info;


use Core\Entities\EntityTypeBase;

class InfoType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("info");
    }
}
