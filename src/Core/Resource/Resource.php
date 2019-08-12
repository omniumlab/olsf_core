<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/04/2018
 * Time: 17:21
 */

namespace Core\Resource;


use Core\Auth\Permissions\PermissionListInterface;
use Core\Entities\EntityInterface;
use Core\Handlers\HandlerInterface;
use Core\Reflection\Finders\EntityFinderInterface;
use Core\Reflection\Finders\HandlerFinderInterface;
use Core\Reflection\NameInterface;

class Resource implements ResourceInterface
{
    /**
     * @var \Core\Reflection\NameInterface
     */
    private $name;

    /**
     * @var EntityFinderInterface
     */
    private $entityFinder;

    /**
     * @var HandlerFinderInterface
     */
    private $handlerLocator;

    /**
     * Resource constructor.
     *
     * @param \Core\Reflection\NameInterface $name Name of the resource
     * @param HandlerFinderInterface $handlerLocator
     * @param EntityFinderInterface $entityFinder
     */
    public function __construct(
        NameInterface $name,
        HandlerFinderInterface $handlerLocator,
        EntityFinderInterface $entityFinder
    ) {
        $this->name = $name;
        $this->handlerLocator = $handlerLocator;
        $this->entityFinder = $entityFinder;
    }

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface
    {
        return $this->name;
    }

    public function getNamespace(): string
    {
        return trim(self::BASE_NAMESPACE . "\\" . $this->getName()->getCamelCase(), "\\");
    }

    /**
     * @param NameInterface $name
     *
     * @param array $injection
     *
     * @return \Core\Handlers\HandlerInterface
     */
    public function getHandler(NameInterface $name, array $injection = [])
    {
        return $this->handlerLocator->getHandler($name, $this->getNamespace(), $injection);
    }

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers(): array
    {
        return $this->handlerLocator->getAll($this->getNamespace());
    }

    /**
     * @param \Core\Auth\Permissions\PermissionListInterface|null $permissionList
     *
     * @return EntityInterface[]
     */
    public function getEntities(PermissionListInterface $permissionList = null): array
    {
        return $this->entityFinder->findEntities($this->getNamespace(), $permissionList);
    }
}