<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 13/07/2018
 * Time: 19:44
 */

namespace Core\Handlers\LoginHandler;


use Core\Auth\Login\Config\LoginConfigInterface;
use Core\Auth\Login\LoginAttempt\BadLoginAttemptInterface;
use Core\Auth\Login\StatelessLoginService;
use Core\Auth\Roles\AnonymousRole;
use Core\Auth\Session\StatelessSessionService;
use Core\Auth\User\UserLoginProviderInterface;
use Core\Exceptions\FailedLoginAttemptsExceededException;
use Core\Text\TextHandlerInterface;

abstract class AbstractStatelessLoginHandler extends AbstractLoginHandler
{
    /**
     * Handler constructor.
     *
     * @param \Core\Auth\User\UserLoginProviderInterface $userProvider
     * @param \Core\Auth\Login\Config\LoginConfigInterface $loginConfig
     * @param \Core\Auth\Login\LoginAttempt\BadLoginAttemptInterface $badLoginAttempt
     * @param TextHandlerInterface $textHandler
     * @param AnonymousRole $anonymousRole
     * @param FailedLoginAttemptsExceededException $failedLoginAttemptsExceededException
     */
    public function __construct(UserLoginProviderInterface $userProvider,
                                LoginConfigInterface $loginConfig, BadLoginAttemptInterface $badLoginAttempt,
                                TextHandlerInterface $textHandler, AnonymousRole $anonymousRole,
                                FailedLoginAttemptsExceededException $failedLoginAttemptsExceededException)
    {
        parent::__construct(new StatelessLoginService($userProvider, new StatelessSessionService(), $loginConfig,
            $badLoginAttempt, $failedLoginAttemptsExceededException), $textHandler, $anonymousRole);
    }

}
