<?php


namespace Core\Entities\Change\FileManager\Zip;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\FileManager\AbstractZipHandler;
use Core\Text\TextHandlerInterface;

class ZipEntity extends AbstractEntity
{
    public function __construct(AbstractZipHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new ZipType(), $textHandler);
    }
}
