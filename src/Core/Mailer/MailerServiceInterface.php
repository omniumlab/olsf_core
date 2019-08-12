<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 18:39
 */

namespace Core\Mailer;


interface MailerServiceInterface
{
    public function createMail(): MailInterface;
}