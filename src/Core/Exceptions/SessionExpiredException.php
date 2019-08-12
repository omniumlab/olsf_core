<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/07/2018
 * Time: 17:57
 */

namespace Core\Exceptions;


use Throwable;

class SessionExpiredException extends \Exception
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
    public function __construct(string $message = "Session expired", int $code = 401, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}