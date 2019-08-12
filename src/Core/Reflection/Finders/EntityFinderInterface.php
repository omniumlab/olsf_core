<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/04/2018
 * Time: 18:55
 */

namespace Core\Reflection\Finders;

use Core\Auth\Permissions\PermissionListInterface;
use Core\Entities\EntityInterface;

interface EntityFinderInterface
{
    /**
     * @param string $resourceNamespace
     *
     * @param \Core\Auth\Permissions\PermissionListInterface $permissionList
     *
     * @return EntityInterface[]
     */
    public function findEntities(string $resourceNamespace, PermissionListInterface $permissionList = null);
}