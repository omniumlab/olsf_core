<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 17/09/2018
 * Time: 16:15
 */

namespace Core\Entities\Change\RestReloadListEntity\Options;


use Core\Entities\Options\EntityOptions;

class ReloadListEntityOptions extends EntityOptions
{

    public function setMethod($method){
        $this->setVariable("method", $method);
    }

}