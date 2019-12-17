<?php


namespace Core\Handlers\ObtainHandlers\TreeList;


use Core\Commands\CommandInterface;
use Core\Handlers\Handler;
use Core\Handlers\ObtainHandlers\TreeList\Value\TreeValue;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractTreeListHandler extends Handler
{
    public function __construct(TextHandlerInterface $textHandler)
    {
        parent::__construct("GET", false, $textHandler);
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $this->getData($command));
    }

    /**
     * @param CommandInterface $command
     * @return TreeValue[]
     */
    abstract function getData(CommandInterface $command): array;
}
