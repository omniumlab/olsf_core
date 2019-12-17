<?php


namespace Core\Entities\Obtain\TreeList\Options;


use Core\Entities\Options\ActionInterface;
use Core\Entities\Options\EntityOptions;

class TreeListEntityOptions extends EntityOptions implements TreeListEntityOptionsInterface
{
    /*
     * Variables
     *
     *  onlyId: bool
     *  entities: array
     */

    public function __construct()
    {
        $this->setOnlyId(true);
        $this->setEntities([]);
    }

    public function setOnlyId(bool $onlyId): TreeListEntityOptionsInterface
    {
        $this->setVariable("onlyId", $onlyId);
        return $this;
    }

    public function setEntities(array $entities): TreeListEntityOptionsInterface
    {
        $this->setVariable("entities", $entities);
        return $this;
    }

    public function addEntity(string $visualName, string $entityName, ?string $actionStyle = ActionInterface::STYLE_SUCCESS): TreeListEntityOptionsInterface
    {
        $this->addItemToVariablesList("entities", [
            "name" => $visualName,
            "entity" => $entityName,
            "style" => $actionStyle
        ]);
        return $this;
    }
}
