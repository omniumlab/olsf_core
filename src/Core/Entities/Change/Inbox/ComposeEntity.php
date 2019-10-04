<?php


namespace Core\Entities\Change\Inbox;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\Inbox\AbstractComposeHandler;
use Core\Text\TextHandlerInterface;

class ComposeEntity extends AbstractEntity
{
    public function __construct(AbstractComposeHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new ComposeType(), $textHandler);
    }
}
