<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/07/2018
 * Time: 9:54
 */

namespace Core\Auth;


use Core\Auth\User\AuthUserInterface;
use Core\Handlers\HandlerInterface;

interface HandlerAccessCheckerInterface
{
    /**
     * @param \Core\Handlers\HandlerInterface $handler
     * @param \Core\Auth\User\AuthUserInterface $user
     *
     * @return mixed
     * @throws \Core\Exceptions\PermissionDeniedException
     */
    public function checkAccess(HandlerInterface $handler, AuthUserInterface $user);
}