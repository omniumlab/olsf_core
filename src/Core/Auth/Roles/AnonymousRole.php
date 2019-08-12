<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 20:40
 */

namespace Core\Auth\Roles;


use Core\Auth\User\UserProviderInterface;

class AnonymousRole extends RoleBase implements AnonymousRoleInterface
{
    /**
     * RoleBase constructor.
     * @param UserProviderInterface $userProvider
     */
    public function __construct(UserProviderInterface $userProvider)
    {
        parent::__construct("anonymous", null, $userProvider);
    }
}
