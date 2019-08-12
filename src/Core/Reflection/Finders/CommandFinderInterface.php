<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 17:23
 */

namespace Core\Reflection\Finders;


use Core\Reflection\NameInterface;

interface CommandFinderInterface
{
    /**
     * @param \Core\Reflection\NameInterface $resourceName
     * @param \Core\Reflection\NameInterface $action
     *
     * @return mixed
     */
    public function findCommand(NameInterface $resourceName, NameInterface $action);
}