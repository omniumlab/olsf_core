<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:38
 */

namespace Core\Auth\Login;


use Core\Auth\Login\Config\LoginConfigInterface;
use Core\Auth\Login\LoginAttempt\BadLoginAttemptInterface;
use Core\Auth\Session\SessionServiceInterface;
use Core\Auth\Session\SessionTokenInterface;
use Core\Auth\User\UserLoginProviderInterface;
use Core\Exceptions\AuthenticationException;
use Core\Exceptions\FailedLoginAttemptsExceededException;
use Core\Exceptions\UserNotActiveException;
use Core\Text\TextHandlerInterface;

class StatelessLoginService implements LoginServiceInterface
{
    /**
     * @var \Core\Auth\User\UserLoginProviderInterface
     */
    private $userProvider;
    /**
     * @var \Core\Auth\Session\StatelessSessionService
     */
    private $sessionService;
    /**
     * @var \Core\Auth\Login\Config\LoginConfigInterface
     */
    private $loginConfig;
    /**
     * @var \Core\Auth\Login\LoginAttempt\BadLoginAttemptInterface
     */
    private $badLoginAttempt;
    /**
     * @var FailedLoginAttemptsExceededException
     */
    private $failedLoginAttemptsExceededException;
    /**
     * @var TextHandlerInterface
     */
    private $textHandler;


    /**
     * StatelessLoginService constructor.
     *
     * @param \Core\Auth\User\UserLoginProviderInterface $userProvider
     * @param \Core\Auth\Session\SessionServiceInterface $sessionService
     * @param \Core\Auth\Login\Config\LoginConfigInterface $loginConfig
     * @param TextHandlerInterface $textHandler
     * @param \Core\Auth\Login\LoginAttempt\BadLoginAttemptInterface $badLoginAttempt
     * @param FailedLoginAttemptsExceededException $failedLoginAttemptsExceededException
     */
    public function __construct(UserLoginProviderInterface $userProvider,
                                SessionServiceInterface $sessionService,
                                LoginConfigInterface $loginConfig,
                                TextHandlerInterface $textHandler,
                                BadLoginAttemptInterface $badLoginAttempt,
                                FailedLoginAttemptsExceededException $failedLoginAttemptsExceededException)
    {
        $this->userProvider = $userProvider;
        $this->sessionService = $sessionService;
        $this->loginConfig = $loginConfig;
        $this->badLoginAttempt = $badLoginAttempt;
        $this->failedLoginAttemptsExceededException = $failedLoginAttemptsExceededException;
        $this->textHandler = $textHandler;
    }

    /**
     * @param string $loginName
     * @param string $password
     *
     * @param int $expiration Tiempo de expiración de la sesión en segundos. Por defecto 1 hora.
     *
     * @return \Core\Auth\Session\SessionTokenInterface
     * @throws \Core\Exceptions\AuthenticationException
     * @throws \Core\Exceptions\FailedLoginAttemptsExceededException
     * @throws \Core\Exceptions\UserNotActiveException
     */
    public function doLogin(string $loginName, string $password, int $expiration = 3600): SessionTokenInterface
    {
        $user = $this->userProvider->getUserByLoginName($loginName);

        if ($user === null) {
            throw new AuthenticationException($this->textHandler);
        }

        if (!$user->isActive())
            throw new UserNotActiveException();

        $loginData = $user->getLoginData();

        if ($this->badLoginAttempt->isBadLoginNumberAttemptExceed($loginData)){
            throw $this->failedLoginAttemptsExceededException;
        }

        if (!password_verify($password, $loginData->getPassword()) && $password !== $loginData->getPassword()) {
            $this->badLoginAttempt->addBadLoginAttempt($loginData, $user);
            throw new AuthenticationException($this->textHandler);
        }

        return $this->sessionService->createSession($user, $expiration);
    }

}
