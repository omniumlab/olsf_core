<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 20:59
 */

namespace Core\Reflection\Finders;


use Core\Bus\CommandBusInterface;
use Core\Commands\CommandInterface;
use Core\Config\ReflectionConfigInterface;
use Core\Reflection\Builders\ObjectCreatorInterface;
use Core\Reflection\NameInterface;

class CommandBusFinder implements CommandBusFinderInterface
{
    /**
     * @var \Core\Reflection\Builders\ObjectCreatorInterface
     */
    private $objectCreator;
    /**
     * @var \Core\Config\ReflectionConfigInterface
     */
    private $config;


    /**
     * CommandBusFinder constructor.
     *
     * @param \Core\Reflection\Builders\ObjectCreatorInterface $objectCreator
     * @param \Core\Config\ReflectionConfigInterface $config
     */
    public function __construct(ObjectCreatorInterface $objectCreator, ReflectionConfigInterface $config)
    {
        $this->objectCreator = $objectCreator;
        $this->config = $config;
    }

    public function findCommandBus(CommandInterface $command): CommandBusInterface
    {
        $className = $this->getHandlerCommandBusClassName($command->getResourceName(), $command->getActionName());
        if (!$this->objectCreator->exists($className)) {
            $className = $this->config->getFallbackCommandBusClassName();

            if (!$this->objectCreator->exists($className)) {
                throw new \LogicException("Service " . $className . " not found");
            }
        }

        return $this->objectCreator->createObject($className);
    }

    private function getHandlerCommandBusClassName(NameInterface $resourceName, NameInterface $handlerName): string
    {
        return "App\\" . $resourceName->getCamelCase() . "\\Bus\\" . $handlerName->getCamelCase(false) . "CommandBus";
    }
}