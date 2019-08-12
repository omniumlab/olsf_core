<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 20/10/17
 * Time: 9:15
 */

namespace Core\Entities\Obtain\ListEntity\Options;

use Core\Entities\ColumnableEntityOptionsInterface;
use Core\Entities\Options\Action;
use Core\Entities\Options\BaseColumn;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Entities\Options\EntityOptions;
use Core\Handlers\ObtainHandlers\ListHandlerInterface;
use Core\Text\TextHandlerInterface;
use Exception;

class ListEntityOptions extends EntityOptions implements ListEntityOptionsInterface, ColumnableEntityOptionsInterface
{
    /*
     * Variables[]
     * "selectable" bool
     * "actionsToSelection" Action[]
     * "actionsGeneric" Action[]
     * "actionsIndividual" Action[]
     * "itemsPerPageAvailable" Integer[]
     * "columns" ListColumn[]
     */


    public function __construct(ListHandlerInterface $queryHandler,
                                ColumnTypeFormatterInterface $columnTypeFormatter,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct();
        $this->setSelectable(false);
        $this->setActionsToSelection([]);
        $this->setActionsGeneric([]);
        $this->setActionsIndividual([]);
        $this->setColumnsByQueryHandler($queryHandler, $columnTypeFormatter, $textHandler);
        $this->setItemsPerPageAvailable([10, 50, 100, 250, 500]);
    }


    private function setColumnsByQueryHandler(
        ListHandlerInterface $queryHandler,
        ColumnTypeFormatterInterface $columnTypeFormatter,
        TextHandlerInterface $textHandler
    )
    {
        $columns = [];
        $columnName = null;

        foreach ($queryHandler->getFields() as $field) {
            $column = new ListColumn($field, $columnTypeFormatter, $textHandler);
            if ($field->isPrimaryKey()) {
                $column->setVisible(false);
            }
            $columns[] = $column;
        }

        $this->setVariable("columns", $columns);
    }


    public function setColumnConfig($columName, $visualName, $sortable)
    {
        $this->getVariable("columns")[$columName]->setVisualName($visualName);
        $this->getVariable("columns")[$columName]->setSortable($sortable);
    }

    /**
     * @param $numberOfItems Integer[]
     */
    public function setItemsPerPageAvailable($numberOfItems)
    {
        $this->setVariable("itemsPerPageAvailable", $numberOfItems);
    }


    public function addActionToSelection(Action $actionToSelection, $index)
    {
        $this->addItemToVariablesList("actionsToSelection", $actionToSelection, $index);
    }

    public function addActionGeneric(Action $actionGeneric, $index)
    {
        $this->addItemToVariablesList("actionsGeneric", $actionGeneric, $index);
    }

    public function addActionIndividual(Action $actionIndividual, $index)
    {
        $this->addItemToVariablesList("actionsIndividual", $actionIndividual, $index);
    }

    /**
     * @return ListColumn
     * @throws Exception
     */
    public function getColumn($columnName)
    {
        $columns = $this->getVariable("columns");

        foreach ($columns as $column) {
            if ($column->getName() == $columnName) {
                return $column;
            }
        }

        throw new Exception("Column name '" . $columnName . "' not found");
    }

    /**
     * @return ListColumn[]
     */
    function getColumns(): array
    {
        return $this->getVariable("columns");
    }


    /**
     * @return bool
     */
    public function isSelectable()
    {
        return $this->getVariable("selectable");
    }

    /**
     * @param bool $selectable
     */
    public function setSelectable($selectable)
    {
        $this->setVariable("selectable", $selectable);
    }

    /**
     * @param $actionToSelections Action[]
     */
    public function setActionsToSelection($actionToSelections)
    {
        $this->setVariable("actionsToSelection", $actionToSelections);
    }

    /**
     * @param $actionsGeneric Action[]
     */
    public function setActionsGeneric($actionsGeneric)
    {
        $this->setVariable("actionsGeneric", $actionsGeneric);
    }

    /**
     * @param $actionsIndividual Action[]
     */
    public function setActionsIndividual($actionsIndividual)
    {
        $this->setVariable("actionsIndividual", $actionsIndividual);
    }

    public function getActionsToSelection(): array
    {
        $this->getVariable("actionsToSelection");
    }

    /**
     * @param $fields string[]
     */
    public function setCrumbFields($fields)
    {
        $this->setVariable("crumbFields", $fields);
    }

    public function getActionsGeneric(): array
    {
        $this->getVariable("actionsGeneric");
    }

    public function getActionsIndividual(): array
    {
        $this->getVariable("actionsIndividual");
    }
}
