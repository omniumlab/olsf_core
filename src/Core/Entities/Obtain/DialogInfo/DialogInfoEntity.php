<?php


namespace Core\Entities\Obtain\DialogInfo;


use Core\Entities\AbstractEntity;
use Core\Handlers\ObtainHandlers\DialogInfo\AbstractDialogInfoHandler;
use Core\Text\TextHandlerInterface;

class DialogInfoEntity extends AbstractEntity
{
    public function __construct(AbstractDialogInfoHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DialogInfoType(), $textHandler);

        $this->getAction()
            ->setIcon("fas fa-info");
    }
}