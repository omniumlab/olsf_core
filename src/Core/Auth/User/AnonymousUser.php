<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 27/06/2018
 * Time: 13:33
 */

namespace Core\Auth\User;


use Core\Auth\Permissions\PermissionListInterface;
use Core\Auth\Roles\AnonymousRole;
use Core\Auth\Roles\RoleInterface;

class AnonymousUser implements AuthUserInterface
{
    /** @var AnonymousRole */
    private $role;

    public function __construct(AnonymousRole $role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return null;
    }

    public function getRole(): ?RoleInterface
    {
        return $this->role;
    }

    public function getPermissions(): ?PermissionListInterface
    {
        return null;
    }

    /**
     * @return \Core\Auth\User\LoginDataInterface Datos de login de este usuario
     */
    public function getLoginData(): LoginDataInterface
    {
        return new LoginData("");
    }

    public function isActive(): bool
    {
        return true;
    }

    public function save()
    {

    }
}
