<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 26/04/2019
 * Time: 11:53
 */

namespace Core\Entities\Obtain\TopMenuSelector;


use Core\Entities\EntityTypeBase;

class TopMenuSelectorType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("top_menu_selector");
    }
}
