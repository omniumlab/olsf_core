<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 22:10
 */

namespace Core\Auth\User;


interface UserProviderInterface
{
    public function getUserById(int $id): ?AuthUserInterface;

    public function getUserByEmail(string $email): ?AuthUserInterface;
}