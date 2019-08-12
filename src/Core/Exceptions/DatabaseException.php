<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 30/07/2018
 * Time: 8:51
 */

namespace Core\Exceptions;


use Throwable;

class DatabaseException extends \Exception
{
    public function __construct(string $message = "Database error", int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}