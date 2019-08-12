<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 22/10/2018
 * Time: 12:13
 */

namespace Core\Services\NotificationPush;


interface PushSenderInterface
{
    const OS_ANDROID = 1;
    const OS_IOS = 2;

    function send(string $token, string $message, int $os, ?string $title = null);
}