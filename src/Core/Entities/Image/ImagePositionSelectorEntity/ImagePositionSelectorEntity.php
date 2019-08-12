<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/02/2019
 * Time: 14:57
 */

namespace Core\Entities\Image\ImagePositionSelectorEntity;


use Core\Entities\Image\ImagePositionSelectorEntity\Options\ImagePositionSelectorOptions;
use Core\Entities\Options\EntityOptionsInterface;
use Core\Entities\Virtual\VirtualEntity;
use Core\Text\TextHandlerInterface;

class ImagePositionSelectorEntity extends VirtualEntity
{
    function __construct(ImagePositionSelectorType $entityType, TextHandlerInterface $textHandler)
    {
        parent::__construct($entityType, $textHandler);
        $this->setOptions(new ImagePositionSelectorOptions());
    }

    /**
     * @return \Core\Entities\Image\ImagePositionSelectorEntity\Options\ImagePositionSelectorEntityOptionsInterface| EntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}