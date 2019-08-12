<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 22:08
 */

namespace Core\Auth\Session;


use Core\Auth\User\AuthUserInterface;
use Core\Auth\User\UserProviderInterface;

interface SessionServiceInterface
{
    /**
     * @param string $sessionToken
     *
     * @param \Core\Auth\User\UserProviderInterface $userProvider
     *
     * @return SessionTokenInterface
     * @throws \Core\Exceptions\SessionExpiredException
     */
    public function checkSession(string $sessionToken, UserProviderInterface $userProvider): SessionTokenInterface;

    public function createSession(AuthUserInterface $user, int $expiration): SessionTokenInterface;
}