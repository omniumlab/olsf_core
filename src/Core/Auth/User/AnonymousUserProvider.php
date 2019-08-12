<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/07/2018
 * Time: 21:22
 */

namespace Core\Auth\User;


class AnonymousUserProvider implements UserProviderInterface
{

    public function getUserById(?int $id): ?AuthUserInterface
    {
        return new AnonymousUser();
    }

    public function getUserByEmail(string $email): ?AuthUserInterface
    {
        return new AnonymousUser();
    }
}