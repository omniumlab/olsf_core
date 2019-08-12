<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 02/11/2017
 * Time: 13:49
 */

namespace Core\Entities\Change\Save\AddEntity;


use Core\Entities\AbstractEntity;
use Core\Entities\Change\Save\Options\SaveEntityOptions;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Handlers\ChangeHandlers\ChangeHandlerInterface;
use Core\Text\TextHandlerInterface;

class AddEntity extends AbstractEntity
{
    /**
     * UpdateEntity constructor.
     *
     * @param ChangeHandlerInterface $changeHandler
     * @param ColumnTypeFormatterInterface $columnFormatter
     * @param TextHandlerInterface $textHandler
     *
     * @throws \Exception
     */
    public function __construct(ChangeHandlerInterface $changeHandler, ColumnTypeFormatterInterface $columnFormatter,
                                TextHandlerInterface $textHandler
    ) {
        parent::__construct($changeHandler, new AddType(), $textHandler);

        $this->setOptions(new SaveEntityOptions($changeHandler, $columnFormatter, $textHandler));

        $this->getAction()
             ->setOnlyIcon(false);
    }

    /**
     * @return \Core\Entities\Options\EntityOptions|\Core\Entities\Options\EntityOptionsInterface|\Core\Entities\Change\Save\Options\SaveEntityOptions
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
