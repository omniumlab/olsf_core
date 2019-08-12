<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/07/2017
 * Time: 15:32
 */
namespace Core\Exceptions;

interface RestExceptionInterface
{
    /**
     * Gets the Exception message
     *
     * @return string the Exception message as a string.
     */
    public function getMessage();

    public function getStatusCode();

    public function getData();
}