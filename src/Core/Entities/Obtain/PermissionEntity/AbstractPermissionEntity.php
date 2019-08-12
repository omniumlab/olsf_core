<?php

namespace Core\Entities\Obtain\PermissionEntity;

use Core\Entities\AbstractEntity;
use Core\Entities\EntityTypeInterface;
use Core\Handlers\HandlerInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractPermissionEntity extends AbstractEntity
{

    private $saveRestUrl;

    function __construct(HandlerInterface $handler, EntityTypeInterface $entityType, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, $entityType, $textHandler);
        $this->setSaveRestUrl($handler->getUrl());
    }

    private function setSaveRestUrl($url)
    {
        if ($url) {
            $this->saveRestUrl = str_replace('permission_list', 'permission_update', $url);
            $this->setVariable("saveRestUrl", $this->saveRestUrl);
        }
    }

}