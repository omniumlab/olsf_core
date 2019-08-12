<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 19:54
 */

namespace Core\Handlers\LoginHandler;


use Core\Auth\User\AuthUserInterface;
use Core\Auth\User\UserProviderInterface;
use Core\Handlers\HandlerInterface;

interface RecoverPasswordHandlerInterface extends HandlerInterface
{
    public function getUserProvider(): UserProviderInterface;

    public function getFullUrl(AuthUserInterface $user): string;
}