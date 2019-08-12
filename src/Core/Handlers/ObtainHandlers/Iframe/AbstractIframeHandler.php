<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 15/05/2019
 * Time: 12:30
 */

namespace Core\Handlers\ObtainHandlers\Iframe;


use Core\Auth\Roles\RoleInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractIframeHandler extends Handler
{
    /** @var RoleInterface */
    private $minRole;

    public function __construct(TextHandlerInterface $textHandler, RoleInterface $role, bool $individual = false)
    {
        $this->minRole = $role;
        parent::__construct("GET", $individual, $textHandler);
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
     * @return \Core\Output\Responses\HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        return new SuccessHandlerResponse(HttpCodes::CODE_OK, ["url" => $this->getIframeUrl($command)]);
    }

    abstract protected function getIframeUrl(\Core\Commands\CommandInterface $command);
}
