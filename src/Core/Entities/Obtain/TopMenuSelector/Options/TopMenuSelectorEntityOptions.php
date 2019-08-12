<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 26/04/2019
 * Time: 11:54
 */

namespace Core\Entities\Obtain\TopMenuSelector\Options;


use Core\Entities\Obtain\ListEntity\Options\ListColumn;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Entities\Options\EntityOptions;
use Core\Fields\Output\Text;
use Core\Handlers\HandlerInterface;
use Core\Text\TextHandlerInterface;

class TopMenuSelectorEntityOptions extends EntityOptions implements TopMenuSelectorEntityOptionsInterface
{

    /*
     * "columns" ListColumn[]
     */

    /** @var TextHandlerInterface */
    private $textHandler;

    /** @var ColumnTypeFormatterInterface */
    private $columnTypeFormatter;

    public function __construct(TextHandlerInterface $textHandler, ColumnTypeFormatterInterface $columnTypeFormatter)
    {
        parent::__construct();
        $this->textHandler = $textHandler;
        $this->columnTypeFormatter = $columnTypeFormatter;
        $this->setColumns([]);
    }

    /**
     * @param ListColumn[] $columns
     */
    public function setColumns(array $columns)
    {
        $this->setVariable("columns", $columns);
    }

    function addColumn(string $fieldName, string $visualName, array $values)
    {
        $listColumn = new ListColumn(new Text($fieldName), $this->columnTypeFormatter, $this->textHandler);
        $listColumn->setVisualName($visualName);
        $listColumn->setType(HandlerInterface::TYPE_SELECT);
        $listColumn->setValuesInList($values);

        $this->addItemToVariablesList("columns", $listColumn);
    }
}
