<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 20:43
 */

namespace Core\Auth\Roles;


use Core\Auth\User\UserProviderInterface;

abstract class AbstractRegularUserRole extends RoleBase
{
    /**
     * RoleBase constructor.
     *
     * @param \Core\Auth\User\UserProviderInterface $userProvider
     */
    public function __construct(UserProviderInterface $userProvider)
    {
        parent::__construct("user", new AnonymousRole($userProvider), $userProvider);
    }
}
