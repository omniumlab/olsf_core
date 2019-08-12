<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/11/2017
 * Time: 14:25
 */

namespace Core\Entities\Change\RestReloadListEntity;


use Core\Entities\AbstractEntity;
use Core\Entities\Change\RestReloadListEntity\Options\ReloadListEntityOptions;
use Core\Handlers\HandlerInterface;
use Core\Text\TextHandlerInterface;

class RestReloadListEntity extends AbstractEntity
{
    function __construct(HandlerInterface $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new ReloadListType(), $textHandler);
        $options = new ReloadListEntityOptions();
        $options->setMethod($this->getHttpMethod());
        $this->setOptions($options);
    }

}