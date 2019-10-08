<?php


namespace Core\Entities\Change\FileManager\Delete;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\FileManager\AbstractDeleteFileHandler;
use Core\Text\TextHandlerInterface;

class DeleteFileEntity extends AbstractEntity
{
    public function __construct(AbstractDeleteFileHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DeleteType(), $textHandler);
    }
}
