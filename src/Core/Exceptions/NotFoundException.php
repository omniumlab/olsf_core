<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 14/07/2017
 * Time: 18:45
 */

namespace Core\Exceptions;


class NotFoundException extends RestException
{

    /**
     * NotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Action or resource not found", int $code = 404)
    {
        parent::__construct($code, $message);
    }
}