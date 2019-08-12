<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 11:21
 */

namespace Core\Log\Service;


use Core\Log\LogInterface;
use Core\Log\Type\LogTypeInterface;

interface LogServiceInterface
{
    public function createLog(LogTypeInterface $type): LogInterface;

    public function save(LogInterface $log, string $userId = null);
}