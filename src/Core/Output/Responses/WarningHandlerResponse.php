<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 19/10/17
 * Time: 13:00
 */

namespace Core\Output\Responses;


class WarningHandlerResponse extends HandlerResponseBase
{

    public function __construct($statusCode, $data = [], $message = "", $jsonOptions = 0)
    {
        parent::__construct($statusCode, $message, $data, parent::TYPE_WARNING, $jsonOptions);
    }
}