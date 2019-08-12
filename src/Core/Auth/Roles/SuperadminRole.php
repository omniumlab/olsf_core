<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 20/08/2018
 * Time: 9:34
 */

namespace Core\Auth\Roles;


use Core\Auth\Permissions\PermissionListInterface;
use Core\Auth\Permissions\SubjectWithPermissionsInterface;
use Core\Auth\Permissions\SuperadminPermissions;
use Core\Auth\User\UserProviderInterface;

abstract class SuperadminRole extends RoleBase implements SuperadminRoleInterface, SubjectWithPermissionsInterface
{
    /** @var SuperadminPermissions  */
    private $permissionList;

    public function __construct(RoleInterface $parent, UserProviderInterface $userProvider)
    {
        parent::__construct("superadmin", $parent, $userProvider);
        $this->permissionList = new SuperadminPermissions();
    }

    public function getPermissions(): string
    {
        return $this->permissionList->getPermissionsString();
    }

    public function getPermissionList(): ?PermissionListInterface
    {
        return $this->permissionList;
    }

    public function isSuperadmin(): bool
    {
        return true;
    }

    public function save()
    {

    }

    public function setPermissionsString(string $permissionString)
    {

    }
}