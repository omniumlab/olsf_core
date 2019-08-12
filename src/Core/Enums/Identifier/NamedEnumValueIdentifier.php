<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/08/2018
 * Time: 16:16
 */

namespace Core\Enums\Identifier;


use Core\Enums\Identifier\Repository\EnumIdRepositoryInterface;
use Core\Reflection\NameInterface;

class NamedEnumValueIdentifier extends EnumValueIdentifier
{
    /**
     * EnumValueIdentifier constructor.
     *
     * @param \Core\Reflection\NameInterface $name
     * @param \Core\Enums\Identifier\Repository\EnumIdRepositoryInterface $idRepository
     */
    public function __construct(NameInterface $name, EnumIdRepositoryInterface $idRepository)
    {
        $stringName = strtoupper($name->getSnakeCase());

        parent::__construct($idRepository->getId($stringName), $stringName);
    }

}