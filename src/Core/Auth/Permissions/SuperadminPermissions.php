<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 22/11/2017
 * Time: 14:21
 */

namespace Core\Auth\Permissions;


/**
 * Class for superadmin role permissions. It has all permissions always. The string conversion for this is "superadmin".
 *
 * @package OLSF\PermissionsBundle\Entities
 */
class SuperadminPermissions implements PermissionListInterface
{

    /**
     * @return string The static string "suepradmin". It means it has all permissions.
     */
    function getPermissionsString()
    {
        return "superadmin";
    }

    /**
     * @return string Alias for <code>getPermissionsString</code>
     */
    function __toString()
    {
        return $this->getPermissionsString();
    }

    /**
     * Checks if the subject has the permission asked.
     *
     * @param PermissionInterface|string $permission
     *
     * @return bool Always true as it is a superadmin.
     */
    function hasPermission($permission): ?bool
    {
        return true;
    }

    /**
     * Not used as this role cannot change its permissions.
     *
     * @param PermissionInterface $permissionToSet
     *
     * @return $this
     *
     */
    function setPermission(PermissionInterface $permissionToSet)
    {
        return $this;
    }

    /**
     * @return bool
     */
    function isSuperadmin()
    {
        return true;
    }

    /**
     * Actualiza los permisos con los que vienen en el parámetro. Los que no existan se añaden y los que sí existan se
     * actualiza el valor en caso de ser distinto
     *
     * @param \Core\Auth\Permissions\PermissionListInterface $permissions
     *
     * @return mixed
     */
    public function updateWith(PermissionListInterface $permissions)
    {

    }

    /**
     * @return \Core\Auth\Permissions\PermissionInterface[]
     */
    public function getAll(): array
    {
        return null;
    }

    /**
     * @return array Todos los permisos en la forma [name => enabled]
     */
    public function toArray(): array
    {
        return [];
    }
}
