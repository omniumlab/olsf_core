<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 02/08/2018
 * Time: 10:13
 */

namespace Core\Auth\Login\Config;


interface LoginConfigInterface
{
    public function getBadLoginAttempts(): int;

    public function getLoginBlockedMinutes(): int;
}