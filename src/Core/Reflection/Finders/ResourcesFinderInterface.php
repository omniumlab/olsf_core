<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/04/2018
 * Time: 17:37
 */

namespace Core\Reflection\Finders;


use Core\Resource\ResourceInterface;

interface ResourcesFinderInterface
{
    /**
     * @return \Core\Resource\ResourceInterface[]
     */
    public function getAllResources(): array;

    /**
     * @param $resourceName
     *
     * @return \Core\Resource\ResourceInterface
     */
    public function find($resourceName): ResourceInterface;
}