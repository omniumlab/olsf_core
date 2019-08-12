<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 12:27
 */

namespace Core\Log\Repository;


use Core\Log\LogInterface;

interface LogRepositoryInterface
{
    public function insert(LogInterface $log, string $userid = null);
}