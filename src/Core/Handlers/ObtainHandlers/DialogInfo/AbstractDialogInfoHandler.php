<?php


namespace Core\Handlers\ObtainHandlers\DialogInfo;


use Core\Commands\CommandInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractDialogInfoHandler extends Handler
{
    public function __construct(TextHandlerInterface $textHandler, bool $individual = true)
    {
        parent::__construct("GET", $individual, $textHandler);
    }

    abstract function getTitle(CommandInterface $command): string;

    abstract function getInfo(CommandInterface $command): string;

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [
            "title" => $this->getTitle($command),
            "info" => $this->getInfo($command),
        ]);
    }
}