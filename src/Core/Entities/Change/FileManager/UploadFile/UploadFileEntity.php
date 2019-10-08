<?php


namespace Core\Entities\Change\FileManager\UploadFile;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\FileManager\AbstractUploadFileHandler;
use Core\Text\TextHandlerInterface;

class UploadFileEntity extends AbstractEntity
{
    public function __construct(AbstractUploadFileHandler $handler,  TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new UploadFileType(), $textHandler);
    }
}
