<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/04/2018
 * Time: 18:44
 */

namespace Core\Reflection\Finders;


use Core\Handlers\HandlerInterface;
use Core\Reflection\Builders\ObjectCreatorInterface;
use Core\Reflection\NameInterface;
use Core\Symfony\RootDirObtainerInterface;

class HandlerFinder extends ClassFinder implements HandlerFinderInterface
{
    /**
     * @var \Core\Reflection\Builders\ObjectCreatorInterface
     */
    private $objectCreator;

    /**
     * HandlerLocator constructor.
     *
     * @param \Core\Reflection\Builders\ObjectCreatorInterface $objectCreator
     * @param RootDirObtainerInterface $rootDirObtainer
     */
    public function __construct(ObjectCreatorInterface $objectCreator, RootDirObtainerInterface $rootDirObtainer)
    {
        parent::__construct($rootDirObtainer);
        $this->objectCreator = $objectCreator;
    }

    /**
     * @param \Core\Reflection\NameInterface $name
     * @param string $resourceNamespace
     *
     * @param array $injection
     *
     * @return \Core\Handlers\HandlerInterface
     */
    public function getHandler(NameInterface $name, string $resourceNamespace, array $injection = [])
    {
        $className = $this->getNamespace($resourceNamespace) . "\\" . $name->getCamelCase();

        return $this->objectCreator->createObject($className, $injection);
    }

    private function getNamespace($resourceNamespace)
    {
        return $resourceNamespace . "\\Handlers";
    }

    /**
     * @param string $resourceNamespace
     *
     * @return \Core\Handlers\HandlerInterface[]
     */
    public function getAll(string $resourceNamespace)
    {
        $classes = $this->getAllClasses($this->getNamespace($resourceNamespace), HandlerInterface::class);

        $handlers = [];

        foreach ($classes as $class) {
            $handler = $this->objectCreator->createObject($class);

            if ($handler !== null) {
                $handlers[] = $handler;
            }
        }

        return $handlers;
    }
}