<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2018
 * Time: 19:17
 */

namespace Core\Auth\Permissions;


interface PermissionsFinderInterface
{
    /**
     * @param \Core\Auth\Permissions\PermissionListInterface $subjectPermissions
     *
     * @return \Core\Auth\Permissions\PermissionListInterface
     */
    public function getAllPermissions(?PermissionListInterface $subjectPermissions = null): PermissionListInterface;
}