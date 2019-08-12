<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/04/2018
 * Time: 21:19
 */

namespace Core\Reflection\Finders;


use Core\Auth\Permissions\PermissionListInterface;
use Core\Entities\EntityInterface;
use Core\Entities\FriendlyEntityInterface;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Reflection\Builders\ObjectCreatorInterface;
use Core\Symfony\RootDirObtainerInterface;
use Core\Text\TextHandlerInterface;

class EntityFinder extends ClassFinder implements EntityFinderInterface
{
    /**
     * @var \Core\Reflection\Builders\ObjectCreatorInterface
     */
    private $objectCreator;
    /**
     * @var \Core\Text\TextHandlerInterface
     */
    private $textHandler;
    /**
     * @var \Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface
     */
    private $columnTypeFormatter;

    /**
     * @var \Core\Entities\FriendlyEntityInterface[][]
     */
    private $friendlyEntities = [];

    /**
     * EntityFinder constructor.
     *
     * @param \Core\Reflection\Builders\ObjectCreatorInterface $objectCreator
     * @param \Core\Text\TextHandlerInterface $textHandler
     * @param \Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface $columnTypeFormatter
     * @param RootDirObtainerInterface $rootDirObtainer
     */
    public function __construct(
        ObjectCreatorInterface $objectCreator,
        TextHandlerInterface $textHandler,
        ColumnTypeFormatterInterface $columnTypeFormatter,
        RootDirObtainerInterface $rootDirObtainer
    ) {
        parent::__construct($rootDirObtainer);
        $this->objectCreator = $objectCreator;
        $this->textHandler = $textHandler;
        $this->columnTypeFormatter = $columnTypeFormatter;
    }

    /**
     * @param string $resourceNamespace
     *
     * @param \Core\Auth\Permissions\PermissionListInterface|null $permissionList
     *
     * @return EntityInterface[]
     */
    public function findEntities(string $resourceNamespace, PermissionListInterface $permissionList = null)
    {
        $entities = [];

        $resourceCustomEntities = $this->getAllClasses($this->getNamespace($resourceNamespace), EntityInterface::class);

        foreach ($resourceCustomEntities as $entityClassName) {
            $entity = $this->createEntity($entityClassName, [], $entities);

            if (!$this->hasPermission($entity, $permissionList)) {
                continue;
            }

            $entities[$entity->getName()] = $entity;
        }

        return array_values($entities);
    }

    private function hasPermission(EntityInterface $entity, PermissionListInterface $permissionList = null)
    {
        if ($permissionList === null || !$entity->getPermission()->isRevocable()) {
            return true;
        }

        return $permissionList->hasPermission($entity->getPermission());
    }

    /**
     * @param string $className
     *
     * @param array $objects
     *
     * @param EntityInterface[] $entities
     *
     * @return EntityInterface
     */
    public function createEntity(string $className, $objects = [], array $entities = [])
    {
        /** @var EntityInterface $entity */
        $entity = $this->objectCreator->createObject($className, $objects);

        if ($entity instanceof FriendlyEntityInterface) {
            $this->findFriends($entity, $entities);
        }

        $this->findEntitiesLookingForFriends($entity);

        return $entity;
    }

    /**
     * Busca a los amigos de la entidad $entityLooking en $entities (son las entidades procesadas hasta el momento).
     *
     * También se añade $entityLooking a $this->friendlyEntities para añadirle posteriormente
     * todas las entidades que necesite y que surgan posteriormente.
     *
     * @param \Core\Entities\FriendlyEntityInterface $entityLooking
     * @param EntityInterface[] $entities
     */
    private function findFriends(FriendlyEntityInterface $entityLooking, array $entities)
    {
        foreach ($entityLooking->getNeededHandlerClassNames() as $handlerClassName) {
            $this->friendlyEntities[$handlerClassName][] = $entityLooking;

            $this->addPreviouslyCreatedEntities($handlerClassName, $entityLooking);

            $lookingResourceName = $entityLooking->getHandler()->getResourceName()->getCamelCase();
            foreach ($entities as $entity) {
                $resourceName = $entity->getHandler()->getResourceName()->getCamelCase();
                if (get_class($entity) === $handlerClassName && $resourceName === $lookingResourceName) {
                    $entityLooking->addFriendEntity($entity);
                }
            }
        }
    }

    /**
     * Añade las entidades que se han creado antes que esta,
     * ya que en ellas no se volverá a comprobar si son necesitadas por otras entidades creadas posteriormente.
     *
     * @param string $handlerClassName
     * @param FriendlyEntityInterface $entityLooking
     */
    private function addPreviouslyCreatedEntities(string $handlerClassName, FriendlyEntityInterface $entityLooking)
    {
        $handlerClassNameResourceName = explode("\\", $handlerClassName)[1];
        $isCreatedPreviously = $entityLooking->getHandler()->getResourceName()->getCamelCase() > $handlerClassNameResourceName;
        if ($isCreatedPreviously){
            $previouslyEntity = $this->objectCreator->createObject($handlerClassName, []);
            $entityLooking->addFriendEntity($previouslyEntity);
        }
    }

    /**
     * Busca entidades que necesiten a $entity como amiga.
     *
     * @param EntityInterface $entity
     */
    private function findEntitiesLookingForFriends(EntityInterface $entity)
    {
        $entityClass = get_class($entity);

        if (!array_key_exists($entityClass, $this->friendlyEntities)) {
            return;
        }

        $friendlyEntities = $this->friendlyEntities[$entityClass];

        array_walk($friendlyEntities, function (FriendlyEntityInterface $friendlyEntity) use ($entity) {
            $friendlyEntity->addFriendEntity($entity);
        });
    }

    private function getNamespace($resourceNamespace)
    {
        return $resourceNamespace . "\\Entities";
    }

}
