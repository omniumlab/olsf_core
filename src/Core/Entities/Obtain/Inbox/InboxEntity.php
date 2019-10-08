<?php


namespace Core\Entities\Obtain\Inbox;


use Core\Entities\AbstractEntity;
use Core\Entities\Obtain\Inbox\Options\InboxEntityOptions;
use Core\Entities\Options\EntityOptionsInterface;
use Core\Handlers\ObtainHandlers\Inbox\AbstractInboxHandler;
use Core\Text\TextHandlerInterface;

class InboxEntity extends AbstractEntity
{
    public function __construct(AbstractInboxHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new InboxType(), $textHandler);
        $this->setOptions(new InboxEntityOptions());
    }

    /**
     * @return InboxEntityOptions | EntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
