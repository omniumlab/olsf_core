<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/07/2018
 * Time: 20:58
 */

namespace Core\Auth\Permissions;


interface SubjectWithPermissionsInterface
{

    public function getPermissions(): string;

    public function getPermissionList(): ?PermissionListInterface;

    public function isSuperadmin(): bool;

    public function setPermissionsString(string $permissionString);

    public function save();
}