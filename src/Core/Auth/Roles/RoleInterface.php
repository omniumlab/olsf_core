<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 20:24
 */

namespace Core\Auth\Roles;


use Core\Auth\User\UserProviderInterface;

interface RoleInterface
{
    /**
     * @return \Core\Auth\Roles\RoleInterface|null Padre de este rol o null si no tiene padre.
     */
    public function getParent(): ?RoleInterface;

    public function isParentOf(RoleInterface $role): bool;

    /**
     * @return string
     */
    public function getName();

    public function getUserProvider(): ?UserProviderInterface;

}