<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/08/2018
 * Time: 11:01
 */

namespace Core\Handlers\ObtainHandlers;


use Core\Handlers\HandlerInterface;

interface SingleResourceHandlerInterface extends HandlerInterface
{
    /**
     * @return \Core\Fields\Output\OutputFieldInterface[]
     */
    public function getFields(): array;
}