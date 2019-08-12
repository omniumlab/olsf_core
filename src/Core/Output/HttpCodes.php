<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 19/10/17
 * Time: 13:10
 */
namespace Core\Output;

class HttpCodes
{
    const CODE_OK = 200;
    const CODE_CREATED = 201;
    const CODE_NOT_CONTENT = 204;

    const CODE_BAD_REQUEST = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_FORBIDDEN = 403;
    const CODE_NOT_FOUND = 404;
    const CODE_CONFLICT = 409;

    const CODE_INTERNAL_SERVER_ERROR = 500;
}