<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:47
 */

namespace Core\Entities\Obtain\Iframe;


use Core\Entities\EntityTypeBase;

class IframeType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("iframe");
    }
}
