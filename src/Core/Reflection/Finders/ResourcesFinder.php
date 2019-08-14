<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/04/2018
 * Time: 17:46
 */

namespace Core\Reflection\Finders;


use Core\Resource\Resource;
use Core\Resource\ResourceInterface;
use Core\Resource\ResourceName;
use Core\Symfony\RootDirObtainerInterface;

class ResourcesFinder extends ClassFinder implements ResourcesFinderInterface
{
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
     * @param HandlerFinder $handlerLocator
     * @param EntityFinder $entityFinder
     * @param RootDirObtainerInterface $rootDirObtainer
     */
    public function __construct(HandlerFinder $handlerLocator, EntityFinder $entityFinder, RootDirObtainerInterface $rootDirObtainer)
    {
        parent::__construct($rootDirObtainer);
        $this->handlerLocator = $handlerLocator;
        $this->entityFinder = $entityFinder;
    }

    private function getResourcesDir()
    {
        return $this->getRootDir() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . ResourceInterface::BASE_NAMESPACE;
    }

    /**
     * @return \Core\Resource\ResourceInterface[]
     */
    public function getAllResources(): array
    {
        $resources = [];

        foreach (glob($this->getResourcesDir() . DIRECTORY_SEPARATOR . "*") as $file) {
            if (!is_dir($file)) {
                continue;
            }

            $resources[] = $this->find(new ResourceName(basename($file)));
        }

        return $resources;
    }

    /**
     * @param $resourceName
     *
     * @return \Core\Resource\ResourceInterface
     */
    public function find($resourceName): ResourceInterface
    {
        return new Resource($resourceName, $this->handlerLocator, $this->entityFinder);
    }
}