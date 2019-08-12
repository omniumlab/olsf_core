<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 02/11/2017
 * Time: 16:36
 */

namespace Core\Entities\Obtain\ListEntity;


use Core\Entities\AbstractEntity;
use Core\Entities\Change\Delete\DeleteMultipleType;
use Core\Entities\Change\Delete\DeleteType;
use Core\Entities\Change\Save\AddEntity\AddType;
use Core\Entities\Change\Save\UpdateEntity\UpdateType;
use Core\Entities\EntityInterface;
use Core\Entities\EntityTypeInterface;
use Core\Entities\FriendlyEntityInterface;
use Core\Entities\Obtain\DetailEntity\DetailType;
use Core\Entities\Obtain\ListEntity\Options\ListEntityOptions;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Handlers\ObtainHandlers\ListHandlerInterface;
use Core\Text\TextHandlerInterface;

class ListEntity extends AbstractEntity implements FriendlyEntityInterface
{
    /**
     * UpdateEntity constructor.
     *
     * @param \Core\Handlers\ObtainHandlers\ListHandlerInterface $listHandler
     * @param \Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface $columnFormatter
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(
        ListHandlerInterface $listHandler,
        ColumnTypeFormatterInterface $columnFormatter,
        TextHandlerInterface $textHandler
    )
    {
        parent::__construct($listHandler, new ListType(), $textHandler);

        $this->setOptions(new ListEntityOptions($listHandler, $columnFormatter, $textHandler));
    }

    /**
     * @return \Core\Entities\Options\EntityOptions|\Core\Entities\Options\EntityOptionsInterface|\Core\Entities\Obtain\ListEntity\Options\ListEntityOptions
     */
    public function getOptions()
    {
        return parent::getOptions();
    }

    /**
     * @return string[]
     */
    public function getNeededHandlerClassNames(): array
    {
        $genericEntities = $this->getGenericEntityClassNames();
        $selectionEntities = $this->getSelectionEntityClassNames();
        $individualEntities = $this->getIndividualEntityClassNames();
        return array_merge($genericEntities, $selectionEntities, $individualEntities);
    }

    /**
     * @return string[]
     */
    public function getGenericEntityClassNames(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getSelectionEntityClassNames(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getIndividualEntityClassNames(): array
    {
        return [];
    }

    /**
     * @param \Core\Entities\EntityInterface $entity
     *
     * @return mixed
     */
    public function addFriendEntity(EntityInterface $entity)
    {
        $entityClass = get_class($entity);
        $entity->setup($this->getTextHandler());

        if (in_array($entityClass, $this->getGenericEntityClassNames()))
            $this->addGenericAction($entity, array_search($entityClass, $this->getGenericEntityClassNames()));
        if (in_array($entityClass, $this->getSelectionEntityClassNames()))
            $this->addSelectionAction($entity, array_search($entityClass, $this->getSelectionEntityClassNames()));
        if (in_array($entityClass, $this->getIndividualEntityClassNames()))
            $this->addIndividualAction($entity, array_search($entityClass, $this->getIndividualEntityClassNames()));
    }

    public function addIndividualAction(EntityInterface $entity, $index = null)
    {

        $this->getOptions()->addActionIndividual($entity->getAction(), $index);
    }

    public function addGenericAction(EntityInterface $entity, $index = null)
    {
        $this->getOptions()->addActionGeneric($entity->getAction(), $index);
    }

    public function addSelectionAction(EntityInterface $entity, $index = null)
    {
        $this->getOptions()->setSelectable(true);
        $this->getOptions()->addActionToSelection($entity->getAction(), $index);
    }

}
