<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/04/2018
 * Time: 18:54
 */

namespace Core\Reflection\Finders;

use Core\Reflection\NameInterface;

interface HandlerFinderInterface
{
    /**
     * @param \Core\Reflection\NameInterface $name
     * @param string $resourceNamespace
     * @param array $injection Objetos que se inyectarán en el handler en el caso de que lo necesite
     *
     * @return \Core\Handlers\HandlerInterface
     */
    public function getHandler(NameInterface $name, string $resourceNamespace, array $injection = []);

    /**
     * @param string $resourceNamespace
     *
     * @return \Core\Handlers\HandlerInterface[]
     */
    public function getAll(string $resourceNamespace);
}