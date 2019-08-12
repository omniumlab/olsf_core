<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/08/2018
 * Time: 9:52
 */

namespace Core\Enums\Identifier\Repository;


use Core\Repository\RepositoryInterface;

interface EnumIdRepositoryInterface extends RepositoryInterface
{
    public function getId(string $key): ?int;

    public function all(): array;
}