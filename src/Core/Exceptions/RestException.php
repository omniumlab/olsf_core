<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 14/07/2017
 * Time: 18:24
 */

namespace Core\Exceptions;


use Symfony\Component\HttpFoundation\Response;

class RestException extends \Exception implements RestExceptionInterface
{
    private $extra = [];

    private $data;

    public function __construct($statusCode, $message, $data = [])
    {
        $this->data = $data;
        parent::__construct($message, $statusCode);
    }

    public function addExtra($name, $value)
    {
        $this->extra[$name] = $value;
    }

    public function getData()
    {
        return $this->data;
    }


    public static function create(\Throwable $exception)
    {
        if ($exception instanceof RestException) {
            return $exception;
        }

        $code = $exception->getCode();

        if ($code === 0 || !is_numeric($code) || $code > 599) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new RestException($code,
                                 self::getMessages($exception) . " in " . $exception->getFile() . " (" . $exception->getLine() . ")");
    }

    /**
     * @param \Throwable $exception
     *
     * @return string
     */
    public static function getMessages(\Throwable $exception)
    {
        if ($exception === null) {
            return "";
        }

        $message = $exception->getMessage();
        $previousException = $exception->getPrevious();

        if ($previousException !== null) {
            $message .= " - " . self::getMessages($previousException);
        }

        return $message;
    }

    public function getStatusCode()
    {
        return $this->getCode();
    }
}