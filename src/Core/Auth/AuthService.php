<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 15/06/2018
 * Time: 17:13
 */

namespace Core\Auth;


use Core\Auth\Session\SessionServiceInterface;
use Core\Auth\User\AnonymousUser;
use Core\Auth\User\AuthUserInterface;
use Core\Auth\User\UserProviderInterface;
use Core\Commands\RequestHeadersInterface;
use Core\Handlers\HandlerInterface;
use Core\Output\Responses\HandlerResponseInterface;

class AuthService implements AuthServiceInterface
{
    /**
     * @var \Core\Auth\HandlerAccessCheckerInterface
     */
    private $handlerAccessChecker;
    /**
     * @var \Core\Auth\Session\SessionServiceInterface
     */
    private $sessionService;
    /**
     * @var \Core\Commands\RequestHeadersInterface
     */
    private $headers;
    /**
     * @var AuthUserInterface
     */
    private $user;
    /**
     * @var \Core\Auth\Session\SessionTokenInterface
     */
    private $token;

    /** @var AnonymousUser  */
    private $anonymousUser;


    /**
     * AuthService constructor.
     *
     * @param \Core\Auth\Session\SessionServiceInterface $sessionService
     * @param \Core\Commands\RequestHeadersInterface $headers
     * @param \Core\Auth\HandlerAccessCheckerInterface $handlerAccessChecker
     * @param AnonymousUser $anonymousUser
     */
    public function __construct(SessionServiceInterface $sessionService, RequestHeadersInterface $headers,
                                HandlerAccessCheckerInterface $handlerAccessChecker, AnonymousUser $anonymousUser)
    {
        $this->sessionService = $sessionService;
        $this->headers = $headers;
        $this->handlerAccessChecker = $handlerAccessChecker;
        $this->anonymousUser = $anonymousUser;
    }

    public function getCurrentConnectedUser(): ?AuthUserInterface
    {
        if ($this->user === null) {
            return $this->anonymousUser;
        }

        return $this->user;
    }

    /**
     * @param \Core\Handlers\HandlerInterface $handler
     *
     * @return mixed
     * @throws \Core\Exceptions\PermissionDeniedException
     * @throws \Core\Exceptions\SessionExpiredException
     */
    public function doAuth(HandlerInterface $handler)
    {
        $this->checkSession($handler->getMininumRole()->getUserProvider());
        $this->handlerAccessChecker->checkAccess($handler, $this->getCurrentConnectedUser());
    }

    /**
     * @param \Core\Auth\User\UserProviderInterface $userProvider
     *
     * @throws \Core\Exceptions\SessionExpiredException
     */
    private function checkSession(UserProviderInterface $userProvider)
    {
        $token = $this->headers->getHeaderValue("X-Auth-Token");

        if (!is_string($token)) {
            $token = '';
        }

        $this->token = $this->sessionService->checkSession($token, $userProvider);
        $userId = $this->token->getUserId();

        if ($userId !== null && $userId !== 0) {
            $this->user = $userProvider->getUserById($userId);
        }
    }

    public function onBeforeResponse(HandlerResponseInterface $response): void
    {
        if ($this->token === null) {
            return;
        }

        $this->token->updateSession();

        $response->setHeader("X-Auth-Token", $this->token->getToken());
    }
}
