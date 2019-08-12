<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/12/2017
 * Time: 9:05
 */

namespace Core\Entities\Obtain\PermissionEntity;


use Core\Entities\Options\Action;
use Core\Entities\Options\EntityOptions;

class PermissionListOptions extends EntityOptions
{

    public function addActionIndividual(Action $actionIndividual){
        $this->addItemToVariablesList("actionsIndividual", $actionIndividual);
    }
}