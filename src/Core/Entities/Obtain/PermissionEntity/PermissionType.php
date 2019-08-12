<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2018
 * Time: 18:14
 */

namespace Core\Entities\Obtain\PermissionEntity;


use Core\Entities\EntityTypeInterface;

class PermissionType implements EntityTypeInterface
{

    function getName(): string
    {
        return "permission_list";
    }
}