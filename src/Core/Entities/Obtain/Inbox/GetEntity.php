<?php


namespace Core\Entities\Obtain\Inbox;


use Core\Entities\AbstractEntity;
use Core\Entities\EntityTypeInterface;
use Core\Handlers\ObtainHandlers\Inbox\AbstractGetHandler;
use Core\Text\TextHandlerInterface;

class GetEntity extends AbstractEntity
{
    public function __construct(AbstractGetHandler $handler, EntityTypeInterface $entityType, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, $entityType, $textHandler);
    }
}
