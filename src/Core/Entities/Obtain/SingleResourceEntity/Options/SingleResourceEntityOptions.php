<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/08/2018
 * Time: 11:19
 */

namespace Core\Entities\Obtain\SingleResourceEntity\Options;

use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Entities\Options\EntityOptions;
use Core\Handlers\ObtainHandlers\SingleResourceHandlerInterface;
use Core\Text\TextHandlerInterface;

class SingleResourceEntityOptions extends EntityOptions implements SingleResourceEntityOptionsInterface
{
    /** @var TextHandlerInterface */
    private $textHandler;

    public function __construct(SingleResourceHandlerInterface $handler,
                                ColumnTypeFormatterInterface $columnTypeFormatter,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct();
        $this->textHandler = $textHandler;
        $this->setColumnsByQueryHandler($handler, $columnTypeFormatter);

    }

    private function setColumnsByQueryHandler(
        SingleResourceHandlerInterface $queryHandler,
        ColumnTypeFormatterInterface $columnTypeFormatter
    ) {
        $columns = [];
        $columnName = null;

        foreach ($queryHandler->getFields() as $field) {
            $column = new SingleResourceColumn($field, $columnTypeFormatter, $this->textHandler);
            if ($field->isPrimaryKey()) {
                $column->setVisible(false);
            }
            $columns[] = $column;
        }

        $this->setVariable("columns", $columns);
    }

}
