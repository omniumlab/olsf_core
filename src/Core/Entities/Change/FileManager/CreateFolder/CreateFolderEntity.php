<?php


namespace Core\Entities\Change\FileManager\CreateFolder;


use Core\Entities\AbstractEntity;
use Core\Handlers\ObtainHandlers\FileManager\AbstractCreateFolderHandler;
use Core\Text\TextHandlerInterface;

class CreateFolderEntity extends AbstractEntity
{
    public function __construct(AbstractCreateFolderHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new CreateFolderType(), $textHandler);
    }
}
