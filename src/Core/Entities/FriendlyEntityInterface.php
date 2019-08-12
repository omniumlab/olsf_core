<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 11/04/2018
 * Time: 21:00
 */

namespace Core\Entities;


interface FriendlyEntityInterface extends EntityInterface
{
    /**
     * @return string[]
     */
    public function getNeededHandlerClassNames(): array;

    /**
     * @param \Core\Entities\EntityInterface $entity
     *
     * @return mixed
     */
    public function addFriendEntity(EntityInterface $entity);
}