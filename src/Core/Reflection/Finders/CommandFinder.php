<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 17:37
 */

namespace Core\Reflection\Finders;


use Core\Commands\CommandInterface;
use Core\Config\ReflectionConfigInterface;
use Core\Reflection\Builders\ObjectCreatorInterface;
use Core\Reflection\NameInterface;

class CommandFinder implements CommandFinderInterface
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
     * HandlerLocator constructor.
     *
     * @param \Core\Reflection\Builders\ObjectCreatorInterface $objectCreator
     * @param \Core\Config\ReflectionConfigInterface $config
     */
    public function __construct(ObjectCreatorInterface $objectCreator, ReflectionConfigInterface $config)
    {
        $this->objectCreator = $objectCreator;
        $this->config = $config;
    }

    /**
     * @param \Core\Reflection\NameInterface $resourceName
     * @param \Core\Reflection\NameInterface $action
     *
     * @return mixed
     */
    public function findCommand(NameInterface $resourceName, NameInterface $action)
    {
        $class = "App\\" . $resourceName->getCamelCase() . "\\Commands\\" . $action->getCamelCase(false) . "Command";

        if (!$this->objectCreator->exists($class)) {
            $class = $this->config->getFallbackCommandClassName($class);
        }

        $command = $this->getCommand($class);

        $command->setActionName($action);
        $command->setResourceName($resourceName);

        return $command;
    }

    private function getCommand($className): CommandInterface
    {
        return $this->objectCreator->createObject($className);
    }
}