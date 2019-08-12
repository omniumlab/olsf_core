<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 27/11/2017
 * Time: 13:37
 */

namespace Core\Entities\Change\Delete;


use Core\Entities\AbstractEntity;
use Core\Handlers\HandlerInterface;
use Core\Text\TextHandlerInterface;

class DeleteEntity extends AbstractEntity
{
    /**
     * DeleteEntity constructor.
     *
     * @param \Core\Handlers\HandlerInterface $handler
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(HandlerInterface $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DeleteType(), $textHandler);

        $this->getAction()
             ->setIcon("fa-trash")
             ->setOnlyIcon(true)
             ->setAskMessage("Are you sure you want to delete this item?");
    }
}