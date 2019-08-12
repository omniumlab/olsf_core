<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:51
 */

namespace Core\Handlers;


use Core\Reflection\Name;

class HandlerName extends Name
{
    /**
     * Name constructor.
     *
     * @param object|string $name
     */
    public function __construct($name)
    {
        parent::__construct($name, "Handler");
    }

}