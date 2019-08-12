<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 19/07/2018
 * Time: 18:04
 */

namespace Core\Reflection\Builders;


use Symfony\Component\DependencyInjection\ContainerInterface;

class SymfonyObjectCreator implements ObjectCreatorInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;


    /**
     * SymfonyObjectCreator constructor.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createObject(string $className, array $objects = [])
    {
        return $this->container->get($className);
    }

    public function exists(string $className)
    {
        return $this->container->has($className);
    }
}