<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 19/10/17
 * Time: 12:52
 */

namespace Core\Output\Responses;


class ErrorHandlerResponse extends HandlerResponseBase
{

    public function __construct($statusCode, $data = [], $message = "", $jsonOptions = 0)
    {
        parent::__construct($statusCode, $message, $data, parent::TYPE_ERROR, $jsonOptions);
    }
}