<?php


namespace Core\Entities\Obtain\TreeList\Options;


use Core\Entities\Options\ActionInterface;

interface TreeListEntityOptionsInterface
{
    function setOnlyId(bool $onlyId): TreeListEntityOptionsInterface;

    function setBlocked(bool $blocked): TreeListEntityOptionsInterface;

    function setExpanded(bool $expanded): TreeListEntityOptionsInterface;

    function setEntities(array $entities): TreeListEntityOptionsInterface;

    function addEntity(string $visualName, string $entityName, ?string $actionStyle = ActionInterface::STYLE_SUCCESS): TreeListEntityOptionsInterface;
}
