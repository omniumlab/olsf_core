<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:30
 */

namespace Core\Auth\User;


interface LoginDataInterface
{

    /**
     * @return string Nombre usado para hacer login, normalmente el usuario o el correo.
     */
    public function getLoginName(): string;

    /**
     * @return string Contraseña hasheada.
     */
    public function getPassword(): string;

    /**
     * @return string Clave secreta de este usuario para codificar el token de sesión.
     */
    public function getSessionTokenSecretKey(): string;

    /**
     * @param AuthUserInterface $user
     * @return string
     */
    public function getRecoverPasswordToken(AuthUserInterface $user): string;

    /**
     * Array de realización de un login incorrecto en Unix time.
     *
     * @return array
     */
    public function getBadLoginAttempts(): array;

    /**
     * Establece el las fechas de login incorrectos. Puede ser un array o un string en json sin decodificar.
     *
     * @param int[]|string $unixTimes
     */
    public function setBadLoginAttempts(array $unixTimes);

    /**
     * @param string $password
     * @param bool $encrypt
     */
    public function setPassword(string $password, bool $encrypt = false);

    public function setLoginName(string $loginName);
}
