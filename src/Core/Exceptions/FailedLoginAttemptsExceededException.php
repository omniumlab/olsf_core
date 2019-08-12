<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 02/08/2018
 * Time: 16:52
 */

namespace Core\Exceptions;


use Core\Text\TextHandlerInterface;

class FailedLoginAttemptsExceededException extends RestException
{

    public function __construct(TextHandlerInterface $textHandler)
    {
        parent::__construct(429, $textHandler->get("failed_login_attempts_exceeded_exception"));
    }
}