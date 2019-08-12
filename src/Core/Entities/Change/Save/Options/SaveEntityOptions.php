<?php
namespace Core\Entities\Change\Save\Options;

use Core\Entities\ColumnableEntityOptionsInterface;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Entities\Options\EntityOptions;
use Core\Handlers\ChangeHandlers\ChangeHandlerInterface;
use Core\Text\TextHandlerInterface;
use Exception;

/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/10/2017
 * Time: 21:57
 */
class SaveEntityOptions extends EntityOptions implements SaveEntityOptionsInterface, ColumnableEntityOptionsInterface
{
    /** @var TextHandlerInterface */
    private $textHandler;

    /*
     * Class variables
     * "dynamic_fields_entity" string|null
     * "saveButton" SaveButton
     * "columns" SaveColumn[] Columns that will appear in the list.
     */

    public function __construct(
        ChangeHandlerInterface $changeHandler,
        ColumnTypeFormatterInterface $columnTypeFormatter,
        TextHandlerInterface $textHandler
    ) {
        parent::__construct();
        $this->textHandler = $textHandler;
        $this->setColumnsByQueryHandler($changeHandler, $columnTypeFormatter);
    }


    public function setColumnsByQueryHandler(
        ChangeHandlerInterface $changeHandler,
        ColumnTypeFormatterInterface $columnTypeFormatter
    ) {
        $columns = [];
        $column = null;

        foreach ($changeHandler->getFields() as $field) {
            $column = new SaveColumn($field, $columnTypeFormatter, $this->textHandler);
            $columns[] = $column;
        }

        $this->setVariable("columns", $columns);
    }

    public function hasColumn(string $columnName): bool
    {
        $columns = $this->getVariable("columns");
        foreach ($columns as $column) {
            if ($column->getName() == $columnName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return SaveColumn
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

    public function setButtonsVisibility(int $visibility)
    {
        $this->setVariable("saveButtonsVisibility", $visibility);
        return $this;
    }

    public function setSaveButton(SaveButton $saveButton)
    {
        $this->setVariable("saveButton", $saveButton);
        return $this;
    }

    /**
     * @return SaveColumn[]
     */
    function getColumns(): array
    {
        return $this->getVariable("columns");
    }

    function setDynamicFieldsEntity(string $entity)
    {
        $this->setVariable("dynamicFieldsEntity", $entity);
    }
}
