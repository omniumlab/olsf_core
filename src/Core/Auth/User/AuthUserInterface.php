<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 15/06/2018
 * Time: 17:11
 */

namespace Core\Auth\User;


use Core\Auth\Roles\RoleInterface;

interface AuthUserInterface
{
    /**
     * @return int
     */
    public function getId();

    public function getRole(): ?RoleInterface;

    public function isActive(): bool;

    /**
     * @return \Core\Auth\User\LoginDataInterface Datos de login de este usuario
     */
    public function getLoginData(): LoginDataInterface;

    public function save();
}