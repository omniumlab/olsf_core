<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 16/01/2018
 * Time: 12:02
 */

namespace Core\Entities\Virtual\ImageCreatorEntity;

use Core\Entities\Virtual\VirtualEntity;
use Core\Reflection\NameInterface;
use Core\Text\TextHandlerInterface;

class ImageCreatorEntity extends VirtualEntity
{
    /**
     * ImageCreatorEntity constructor.
     *
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(TextHandlerInterface $textHandler)
    {
        parent::__construct(new ImageCreatorType(), $textHandler);
    }
}