<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 12:56
 */

namespace Core\Bus;


use Core\Auth\AuthServiceInterface;
use Core\Commands\CommandInterface;
use Core\Exceptions\NotFoundException;
use Core\Handlers\HandlerInterface;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Reflection\Finders\ResourcesFinderInterface;

class SimpleCommandBus implements CommandBusInterface
{
    /**
     * @var \Core\Auth\AuthServiceInterface
     */
    private $authService;
    /**
     * @var \Core\Reflection\Finders\ResourcesFinderInterface
     */
    private $resourcesFinder;


    /**
     * SimpleCommandBus constructor.
     *
     * @param \Core\Reflection\Finders\ResourcesFinderInterface $resourcesFinder
     * @param \Core\Auth\AuthServiceInterface $authService
     */
    public function __construct(ResourcesFinderInterface $resourcesFinder, AuthServiceInterface $authService)
    {
        $this->authService = $authService;
        $this->resourcesFinder = $resourcesFinder;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\PermissionDeniedException
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Throwable
     */
    public function dispatch(CommandInterface $command): HandlerResponseInterface
    {
        try {
            $this->onStart($command);
            $handler = $this->findHandler($command);
            $this->onAfterFindHandler($command);
            $response = $handler->handle($command);
            $this->authService->onBeforeResponse($response);
            $this->onResponse($response, $command,$handler->getLogResponse());

            if (!$command->getHeader("x-with-image", true))
                $this->removeImages($response);
            return $response;
        } catch (\Throwable $exception) {
            $this->onException($exception, $command);

            throw $exception;
        }
    }

    private function removeImages(HandlerResponseInterface &$response)
    {
        $data = $response->getData();

        array_walk_recursive($data, function (&$value, $key) {
            if (is_string($value) && substr($value, 0, 11) === "data:image/")
                $value = "[IMAGE]";
        });

        $response->setData($data);
    }

    /**
     * Called before finding the handler
     *
     * @param \Core\Commands\CommandInterface $command
     */
    protected function onStart(CommandInterface $command)
    {

    }

    /**
     * Called after finding the handler
     *
     * @param \Core\Commands\CommandInterface $command
     */
    protected function onAfterFindHandler(CommandInterface $command)
    {

    }

    /**
     * Called after finding the handler but before calling it.
     *
     * @param \Core\Commands\CommandInterface $command
     * @param \Core\Handlers\HandlerInterface $handler
     */
    protected function onHandlerFound(CommandInterface $command, HandlerInterface $handler)
    {

    }

    /**
     * Called before returning the response
     *
     * @param \Core\Output\Responses\HandlerResponseInterface $response
     * @param CommandInterface $command
     * @param array $logResponse
     */
    protected function onResponse(HandlerResponseInterface $response, CommandInterface $command, array $logResponse)
    {

    }

    /**
     * Called when some exception reach the bus
     *
     * @param \Throwable $exception
     * @param CommandInterface $command
     */
    protected function onException(\Throwable $exception, CommandInterface $command)
    {

    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Handlers\HandlerInterface|null
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Core\Exceptions\PermissionDeniedException
     */
    protected function findHandler(CommandInterface $command)
    {
        $resource = $this->resourcesFinder->find($command->getResourceName());
        $handler = $resource->getHandler($command->getActionName());

        if ($handler === null || $handler->getHttpMethod() !== $command->getHttpVerb()) {
            throw new NotFoundException();
        }

        $this->onHandlerFound($command, $handler);

        $this->authService->doAuth($handler);

        return $handler;
    }
}
