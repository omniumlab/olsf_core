<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/03/2018
 * Time: 9:14
 */

namespace Core\Entities\Obtain\DashboardEntity;


use Core\Entities\AbstractEntity;
use Core\Handlers\ObtainHandlers\Dashboard\DashboardHandlerInterface;
use Core\Text\TextHandlerInterface;

class DashboardEntity extends AbstractEntity
{
    public function __construct(DashboardHandlerInterface $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new DashboardType(), $textHandler);
    }

}