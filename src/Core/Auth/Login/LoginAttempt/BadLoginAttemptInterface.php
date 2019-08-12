<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 02/08/2018
 * Time: 16:32
 */

namespace Core\Auth\Login\LoginAttempt;


use Core\Auth\User\AuthUserInterface;
use Core\Auth\User\LoginDataInterface;

interface BadLoginAttemptInterface
{

    /**
     * Almacena un intento de login fallido
     *
     * @param LoginDataInterface $loginData
     * @param AuthUserInterface $user
     */
    public function addBadLoginAttempt(LoginDataInterface $loginData, AuthUserInterface $user);

    /**
     * Comprueba si el usuario ha sobrepasado el número de login incorrectos
     * @param LoginDataInterface $loginData
     * @return bool
     */
    public function isBadLoginNumberAttemptExceed(LoginDataInterface $loginData);
}