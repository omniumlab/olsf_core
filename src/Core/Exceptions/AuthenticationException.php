<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:49
 */

namespace Core\Exceptions;


use Throwable;

class AuthenticationException extends \Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link http://php.net/manual/en/exception.construct.php
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
     *
     * @since 5.1.0
     */
    public function __construct(string $message = "Login or password incorrect", int $code = 401,
                                \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}