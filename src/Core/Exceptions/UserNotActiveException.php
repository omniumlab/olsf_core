<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/08/2018
 * Time: 12:18
 */

namespace Core\Exceptions;


use Throwable;

class UserNotActiveException extends \Exception
{

    public function __construct($message = "This user is not actived", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}