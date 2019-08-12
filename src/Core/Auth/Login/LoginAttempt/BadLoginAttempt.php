<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 02/08/2018
 * Time: 16:35
 */

namespace Core\Auth\Login\LoginAttempt;


use Core\Auth\Login\Config\LoginConfigInterface;
use Core\Auth\User\AuthUserInterface;
use Core\Auth\User\LoginDataInterface;

class BadLoginAttempt implements BadLoginAttemptInterface
{
    /** @var int */
    private $loginBlockedMinutes;
    /** @var int */
    private $badLoginAttemptAllowed;

    function __construct(LoginConfigInterface $loginConfig)
    {
        $this->loginBlockedMinutes = $loginConfig->getLoginBlockedMinutes();
        $this->badLoginAttemptAllowed = $loginConfig->getBadLoginAttempts();
    }

    /**
     * Almacena un intento de login fallido
     *
     * @param LoginDataInterface $loginData
     * @param AuthUserInterface $user
     */
    public function addBadLoginAttempt(LoginDataInterface $loginData, AuthUserInterface $user)
    {
        $badLoginAttemtps = $loginData->getBadLoginAttempts();

        $notExpiredLoginAttempts = $this->filterNotExpiredLoginAttempts($badLoginAttemtps);
        $notExpiredLoginAttempts[] = time();

        $loginData->setBadLoginAttempts($notExpiredLoginAttempts);
        $user->save();
    }

    /**
     * Comprueba si el usuario ha sobrepasado el número de login incorrectos
     * @param LoginDataInterface $loginData
     * @return bool
     */
    public function isBadLoginNumberAttemptExceed(LoginDataInterface $loginData)
    {
        $badLoginAttempts = $loginData->getBadLoginAttempts();
        $badLoginAttempts = $this->filterNotExpiredLoginAttempts($badLoginAttempts);

        return count($badLoginAttempts) >= $this->badLoginAttemptAllowed;
    }

    /**
     * Elimina los intentos de login fallido ya expirados.
     *
     * @param array $badLoginAttempts
     * @return array
     */
    private function filterNotExpiredLoginAttempts(array $badLoginAttempts): array
    {
        $expireTime = strtotime("-" . $this->loginBlockedMinutes . " minute");
        $notExpiredLoginAttempts = [];
        foreach ($badLoginAttempts as $attemtp){
            if ($attemtp >= $expireTime){
                $notExpiredLoginAttempts[] = $attemtp;
            }
        }
        return $notExpiredLoginAttempts;
    }
}