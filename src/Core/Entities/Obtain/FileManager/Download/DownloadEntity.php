<?php


namespace Core\Entities\Obtain\FileManager\Download;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\FileManager\AbstractDownloadHandler;
use Core\Text\TextHandlerInterface;

class DownloadEntity extends AbstractEntity
{
    public function __construct(AbstractDownloadHandler $handler,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DownloadType(), $textHandler);
    }
}
