<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 28/11/2017
 * Time: 11:53
 */

namespace Core\Entities\Change\Delete;


use Core\Entities\AbstractEntity;
use Core\Entities\Options\ActionInterface;
use Core\Handlers\ChangeHandlers\Delete\DeleteMultipleHandlerInterface;
use Core\Text\TextHandlerInterface;

class DeleteMultipleEntity extends AbstractEntity
{

    /**
     * DeleteMultipleEntity constructor.
     *
     * @param DeleteMultipleHandlerInterface $handler
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(DeleteMultipleHandlerInterface $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DeleteMultipleType(), $textHandler);

        $this->getAction()
            ->setIcon("fa-trash")
            ->setOnlyIcon(false)
            ->setAskMessage($textHandler->get("delete_text"))
            ->setStyle(ActionInterface::STYLE_DANGER);
    }
}