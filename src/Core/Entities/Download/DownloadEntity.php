<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 24/04/2019
 * Time: 12:50
 */

namespace Core\Entities\Download;


use Core\Entities\AbstractEntity;
use Core\Handlers\HandlerInterface;
use Core\Text\TextHandlerInterface;

class DownloadEntity extends AbstractEntity
{
    public function __construct(HandlerInterface $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DownloadType(), $textHandler);
        $this->getAction()
            ->setIcon("fas fa-download");
    }
}
