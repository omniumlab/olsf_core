<?php


namespace Core\Entities\Change\FileManager\Rename;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\FileManager\AbstractRenameHandler;
use Core\Text\TextHandlerInterface;

class RenameEntity extends AbstractEntity
{
    public function __construct(AbstractRenameHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new RenameType(), $textHandler);
    }
}
