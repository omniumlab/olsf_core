<?php


namespace Core\Entities\Obtain\TreeList;


use Core\Entities\AbstractEntity;
use Core\Entities\Obtain\TreeList\Options\TreeListEntityOptions;
use Core\Entities\Obtain\TreeList\Options\TreeListEntityOptionsInterface;
use Core\Handlers\ObtainHandlers\TreeList\AbstractTreeListHandler;
use Core\Text\TextHandlerInterface;

class TreeListEntity extends AbstractEntity
{


    public function __construct(AbstractTreeListHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new TreeListType(), $textHandler);
        $this->setOptions(new TreeListEntityOptions());
    }

    /**
     * @return \Core\Entities\Options\EntityOptions|\Core\Entities\Options\EntityOptionsInterface|TreeListEntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
