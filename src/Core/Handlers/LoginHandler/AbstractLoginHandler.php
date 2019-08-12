<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:34
 */

namespace Core\Handlers\LoginHandler;


use Core\Auth\Login\LoginServiceInterface;
use Core\Auth\Roles\AnonymousRole;
use Core\Auth\Roles\RoleInterface;
use Core\Handlers\Handler;
use Core\Output\Responses\ApiLoginResponse;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractLoginHandler extends Handler
{
    /**
     * @var \Core\Auth\Login\LoginServiceInterface
     */
    private $loginService;

    /** @var RoleInterface */
    private $minRole;

    /**
     * Handler constructor.
     *
     * @param \Core\Auth\Login\LoginServiceInterface $loginService
     * @param TextHandlerInterface $textHandler
     * @param AnonymousRole $role
     */
    public function __construct(LoginServiceInterface $loginService,
                                TextHandlerInterface $textHandler, AnonymousRole $role)
    {
        $this->minRole = $role;
        parent::__construct("POST", false, $textHandler);

        $this->loginService = $loginService;
        $this->getPermission()->setNotRevocable();
    }


    /**
     * Mínimo rol requerido para ejecutar este handler.
     *
     * @return \Core\Auth\Roles\RoleInterface|null
     */
    public function getMininumRole(): ?RoleInterface
    {
        return $this->minRole;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return ApiLoginResponse
     * @throws \Core\Exceptions\AuthenticationException
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function handle($command): HandlerResponseInterface
    {
        $loginName = $command->getString("_username", '', true);
        $password = $command->getString("_password", '', true);
        $expiration = $command->getInt("expiration", 3600, false);

        $token = $this->loginService->doLogin($loginName, $password, $expiration);

        return new ApiLoginResponse($token);
    }
}
