<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/12/2017
 * Time: 9:58
 */

namespace Core\Entities\Virtual\RestGoBackEntity;


use Core\Entities\Virtual\VirtualEntity;
use Core\Reflection\NameInterface;
use Core\Text\TextHandlerInterface;

class RestGoBackEntity extends VirtualEntity
{
    public function __construct(NameInterface $resourceName, TextHandlerInterface $textHandler)
    {
        parent::__construct(new GoBackType(), $textHandler);
    }
}