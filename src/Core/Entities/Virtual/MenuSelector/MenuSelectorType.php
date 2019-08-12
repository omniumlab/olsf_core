<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 07/05/2019
 * Time: 13:49
 */

namespace Core\Entities\Virtual\MenuSelector;


use Core\Entities\EntityTypeBase;

class MenuSelectorType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("menu-selector");
    }
}
