<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:44
 */

namespace Core\Resource;


use Core\Reflection\Name;

class ResourceName extends Name
{
    /**
     * Name constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        parent::__construct($name, "");
    }

}