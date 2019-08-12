<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:23
 */

namespace Core\Entities\Virtual\ImageCreatorEntity;


use Core\Entities\EntityTypeBase;

class ImageCreatorType extends EntityTypeBase
{

    /**
     * EntityTypeBase constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("image-creator");
    }
}