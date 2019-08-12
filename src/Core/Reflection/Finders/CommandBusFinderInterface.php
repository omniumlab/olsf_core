<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 20:51
 */

namespace Core\Reflection\Finders;


use Core\Bus\CommandBusInterface;
use Core\Commands\CommandInterface;

interface CommandBusFinderInterface
{
    public function findCommandBus(CommandInterface $command): CommandBusInterface;
}