<?php


namespace Core\Entities\Change\FileManager\MoveTo;


use Core\Entities\AbstractEntity;
use Core\Handlers\ChangeHandlers\FileManager\AbstractMoveToHandler;
use Core\Text\TextHandlerInterface;

class MoveToEntity extends AbstractEntity
{
    public function __construct(AbstractMoveToHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new MoveToType(), $textHandler);
    }
}
