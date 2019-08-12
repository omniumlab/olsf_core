<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/11/2017
 * Time: 10:39
 */

namespace Core\Auth\Permissions;


class PermissionList implements PermissionListInterface
{
    /**
     * @var PermissionInterface[]
     */
    private $permisions = [];

    /**
     * PermissionList constructor.
     *
     * @param string $permissions
     */
    public function __construct(string $permissions = '')
    {
        if ($permissions) {
            $this->updatePermissions($permissions);
        }
    }

    private function updatePermissions($permissions)
    {
        $permissions = explode("#", $permissions);

        foreach ($permissions as $permissionString) {
            $permission = Permission::createFromString($permissionString);

            if ($permission !== null) {
                $this->setPermission($permission);
            }
        }
    }

    /**
     * @return string
     */
    public function getPermissionsString()
    {
        $permissionsString = [];

        foreach ($this->permisions as $permision) {
            $permissionsString[] = $permision->__toString();
        }

        return implode("#", $permissionsString);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getPermissionsString();
    }

    /**
     * @param PermissionInterface|string $permissionToCheck
     *
     * @return bool|null
     * @throws \Core\Exceptions\PermissionNotFoundException
     */
    public function hasPermission($permissionToCheck): ?bool
    {
        if (is_string($permissionToCheck))
            $permissionToCheck = new Permission($permissionToCheck);

        if ($permissionToCheck->isInWhiteList()) {
            return true;
        }

        $permission = $this->getPermission($permissionToCheck);

        if ($permission === null) {
            return null;
        }

        return $permission->isEnabled();
    }

    /**
     * @param PermissionInterface $permissionToSet
     *
     * @return mixed
     *
     */
    public function setPermission(PermissionInterface $permissionToSet)
    {
        $permission = $this->getPermission($permissionToSet);

        if ($permission === null) {
            $permission = new Permission($permissionToSet->getName());

            $this->permisions[$permission->getName()] = $permission;
        }

        $permission->setEnabled($permissionToSet->isEnabled());
    }

    private function getPermission(PermissionInterface $permissionToCheck)
    {
        if (isset($this->permisions[$permissionToCheck->getName()])) {
            return $this->permisions[$permissionToCheck->getName()];
        }

        return null;
    }

    /**
     * @return bool
     */
    function isSuperadmin()
    {
        return count($this->permisions) > 0 && array_key_exists("superadmin", $this->permisions);
    }

    function setSuperAdmin()
    {
        $this->permisions[] = new Permission("superadmin");
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
        foreach ($this->getAll() as $permission) {
            $this->setPermission($permission);
        }
    }

    /**
     * @return \Core\Auth\Permissions\PermissionInterface[]
     */
    public function getAll(): array
    {
        return $this->permisions;
    }

    public function toArray(): array
    {
        $permissions = [];

        foreach ($this->getAll() as $permission) {
            $permissions[$permission->getName()] = $permission->isEnabled();
        }

        return $permissions;
    }
}
