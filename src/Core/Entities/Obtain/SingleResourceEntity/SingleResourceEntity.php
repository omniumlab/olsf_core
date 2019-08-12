<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/08/2018
 * Time: 9:38
 */

namespace Core\Entities\Obtain\SingleResourceEntity;


use Core\Entities\AbstractEntity;
use Core\Entities\Obtain\SingleResourceEntity\Options\SingleResourceEntityOptions;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Handlers\ObtainHandlers\SingleResourceHandlerInterface;
use Core\Text\TextHandlerInterface;

class SingleResourceEntity extends AbstractEntity
{

    function __construct(SingleResourceHandlerInterface $handler, ColumnTypeFormatterInterface $columnTypeFormatter, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new SingleResourceType(), $textHandler);
        $this->setOptions(new SingleResourceEntityOptions($handler, $columnTypeFormatter, $textHandler));
    }

}
