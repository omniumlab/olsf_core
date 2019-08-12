<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 07/05/2019
 * Time: 13:49
 */

namespace Core\Entities\Virtual\MenuSelector;


use Core\Auth\Roles\RoleInterface;
use Core\Entities\Virtual\VirtualEntity;
use Core\Text\TextHandlerInterface;

class MenuSelectorEntity extends VirtualEntity
{
    public function __construct(TextHandlerInterface $textHandler, RoleInterface $minRole = null)
    {
        parent::__construct(new MenuSelectorType(), $textHandler, $minRole);
        $this->getPermission()->setNotRevocable();
    }
}
