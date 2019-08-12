<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:36
 */

namespace Core\Auth\Login;


use Core\Auth\Session\SessionTokenInterface;

interface LoginServiceInterface
{
    /**
     * @param string $loginName
     * @param string $password
     * @param int $expiration
     *
     * @return \Core\Auth\Session\SessionTokenInterface
     * @throws \Core\Exceptions\AuthenticationException
     */
    public function doLogin(string $loginName, string $password, int $expiration = 3600): SessionTokenInterface;
}