<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/04/2018
 * Time: 17:16
 */

namespace Core\Resource;


use Core\Auth\Permissions\PermissionListInterface;
use Core\Entities\EntityInterface;
use Core\Handlers\HandlerInterface;
use Core\Reflection\NameInterface;

interface ResourceInterface
{
    const BASE_NAMESPACE = 'App';

    public function getName(): NameInterface;

    public function getNamespace(): string;

    /**
     * @param \Core\Reflection\NameInterface $name
     *
     * @param array $injection
     *
     * @return \Core\Handlers\HandlerInterface|null
     */
    public function getHandler(NameInterface $name, array $injection = []);

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers(): array;

    /**
     * @param \Core\Auth\Permissions\PermissionListInterface|null $permissionList
     *
     * @return EntityInterface[]
     */
    public function getEntities(PermissionListInterface $permissionList = null): array;
}