<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 26/04/2019
 * Time: 11:52
 */

namespace Core\Entities\Obtain\TopMenuSelector;


use Core\Auth\Roles\RoleInterface;
use Core\Entities\Obtain\TopMenuSelector\Options\TopMenuSelectorEntityOptions;
use Core\Entities\Obtain\TopMenuSelector\Options\TopMenuSelectorEntityOptionsInterface;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Entities\Options\EntityOptionsInterface;
use Core\Entities\Virtual\VirtualEntity;
use Core\Text\TextHandlerInterface;

class TopMenuSelectorEntity extends VirtualEntity
{
    public function __construct(TextHandlerInterface $textHandler, ColumnTypeFormatterInterface $columnTypeFormatter
        , RoleInterface $minRole = null)
    {
        parent::__construct(new TopMenuSelectorType(), $textHandler, $minRole);
        $this->setOptions(new TopMenuSelectorEntityOptions($textHandler, $columnTypeFormatter));
    }

    /**
     * @return TopMenuSelectorEntityOptionsInterface|EntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
