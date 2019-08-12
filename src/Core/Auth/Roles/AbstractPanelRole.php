<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 20:42
 */

namespace Core\Auth\Roles;


use App\Roles\RegularUserRole;
use Core\Auth\User\UserProviderInterface;

abstract class AbstractPanelRole extends RoleBase
{
    /**
     * RoleBase constructor.
     *
     * @param \App\Roles\RegularUserRole $role
     * @param \Core\Auth\User\UserProviderInterface $userProvider
     */
    public function __construct(RoleInterface $role, UserProviderInterface $userProvider)
    {
        parent::__construct("panel", $role, $userProvider);
    }
}