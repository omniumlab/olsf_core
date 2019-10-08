<?php


namespace Core\Entities\Obtain\FileManager;


use Core\Entities\AbstractEntity;
use Core\Entities\Obtain\FileManager\Options\FileManagerEntityOptions;
use Core\Handlers\ObtainHandlers\FileManager\AbstractFileManagerHandler;
use Core\Text\TextHandlerInterface;

class FileManagerEntity extends AbstractEntity
{
    public function __construct(AbstractFileManagerHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new FileManagerType(), $textHandler);
        $this->setOptions(new FileManagerEntityOptions());
    }

    /**
     * @return FileManagerEntityOptions | \Core\Entities\Options\EntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
