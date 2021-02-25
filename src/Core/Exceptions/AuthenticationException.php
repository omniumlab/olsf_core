<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:49
 */

namespace Core\Exceptions;


use Core\Text\TextHandlerInterface;
use Throwable;

class AuthenticationException extends  RestException
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link http://php.net/manual/en/exception.construct.php
     *
     * @param TextHandlerInterface $textHandler
     * @since 5.1.0
     */
    public function __construct(TextHandlerInterface $textHandler)
    {
        parent::__construct( 401, $textHandler->get("failed_login_password_incorrect_exception"));
    }

}