<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/02/2019
 * Time: 14:58
 */

namespace Core\Entities\Image\ImagePositionSelectorEntity;


use Core\Entities\EntityTypeBase;

class ImagePositionSelectorType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("image-position-selector");
    }
}