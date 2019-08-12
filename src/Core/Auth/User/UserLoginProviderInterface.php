<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:42
 */

namespace Core\Auth\User;


interface UserLoginProviderInterface
{
    /**
     * Busca el usuario dado su login name (username, email, etc.)
     *
     * @param string $loginName Login name del usuario que se busca.
     *
     * @return \Core\Auth\User\AuthUserInterface|null Usuario encontrado o null si no se ha encontrado usuario.
     */
    public function getUserByLoginName(string $loginName): ?AuthUserInterface;
}