<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 9:54
 */

namespace Core\Bus;


use Core\Commands\CommandInterface;
use Core\Output\Responses\HandlerResponseInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): HandlerResponseInterface;
}