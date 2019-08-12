<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 22:09
 */

namespace Core\Auth\Session;


use Core\Auth\User\AuthUserInterface;
use Core\Auth\User\UserProviderInterface;
use Core\Exceptions\UserNotActiveException;

class StatelessSessionService implements SessionServiceInterface
{
    /**
     * @param string $sessionToken
     *
     * @param \Core\Auth\User\UserProviderInterface $userProvider
     * @return SessionTokenInterface|null
     * @throws UserNotActiveException
     * @throws \Core\Exceptions\SessionExpiredException
     */
    public function checkSession(string $sessionToken, UserProviderInterface $userProvider): SessionTokenInterface
    {
        $token = new StatelessSessionToken($sessionToken);
        $userId = $token->getUserId();

        if ($userId !== null && $userId !== 0) {
            $user = $userProvider->getUserById($userId);

            if (!$user->isActive())
                throw new UserNotActiveException();

            $token->check($user->getLoginData()->getSessionTokenSecretKey());
        }

        return $token;
    }

    public function createSession(AuthUserInterface $user, int $expiration): SessionTokenInterface
    {
        $token = new StatelessSessionToken();

        $userId = $user->getId();
        $secretKey = $user->getLoginData()->getSessionTokenSecretKey();

        $token->createToken($userId, $secretKey, $expiration);

        return $token;
    }
}
