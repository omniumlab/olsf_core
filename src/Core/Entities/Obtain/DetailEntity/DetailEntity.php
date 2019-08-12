<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/01/2018
 * Time: 11:56
 */

namespace Core\Entities\Obtain\DetailEntity;


use Core\Entities\AbstractEntity;
use Core\Handlers\ObtainHandlers\DetailHandlerInterface;
use Core\Text\TextHandlerInterface;

class DetailEntity extends AbstractEntity
{

    public function __construct(DetailHandlerInterface $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DetailType(), $textHandler);

        $this->getAction()
             ->setOnlyIcon(true)
             ->setIcon("fa-eye");
    }
}