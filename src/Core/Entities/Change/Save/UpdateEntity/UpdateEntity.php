<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 02/11/2017
 * Time: 14:46
 */

namespace Core\Entities\Change\Save\UpdateEntity;


use Core\Entities\AbstractEntity;
use Core\Entities\Change\Save\Options\SaveEntityOptions;
use Core\Entities\Change\Save\Options\UpdateEntity\UpdateEntityOptions;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Handlers\ChangeHandlers\ChangeHandlerInterface;
use Core\Text\TextHandlerInterface;

class UpdateEntity extends AbstractEntity
{
    /**
     * UpdateEntity constructor.
     *
     * @param \Core\Handlers\ChangeHandlers\ChangeHandlerInterface $changeHandler
     * @param \Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface $columnFormatter
     * @param \Core\Text\TextHandlerInterface $textHandler
     */
    public function __construct(
        ChangeHandlerInterface $changeHandler,
        ColumnTypeFormatterInterface $columnFormatter,
        TextHandlerInterface $textHandler
    ) {
        parent::__construct($changeHandler, new UpdateType(), $textHandler);

        $this->setOptions(new UpdateEntityOptions($changeHandler, $columnFormatter, $textHandler));

        $this->getAction()
             ->setOnlyIcon(true)
             ->setIcon("fas fa-edit");
    }

    /**
     * @return \Core\Entities\Options\EntityOptions|\Core\Entities\Options\EntityOptionsInterface|\Core\Entities\Change\Save\Options\UpdateEntity\UpdateEntityOptions
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
