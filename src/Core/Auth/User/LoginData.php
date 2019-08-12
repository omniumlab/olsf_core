<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/07/2018
 * Time: 21:52
 */

namespace Core\Auth\User;


use Core\Auth\Session\StatelessSessionToken;

class LoginData implements LoginDataInterface
{
    /**
     * @var string
     */
    private $loginName;
    /**
     * @var string
     */
    private $password = '';
    /**
     * @var string
     */
    private $sessionTokenSecretKey = '';
    /**
     * @var string
     */
    private $recoverPasswordToken = '';
    /**
     * @var array
     */
    private $badLoginAttempts = [];


    /**
     * LoginData constructor.
     *
     * @param string $loginName
     */
    public function __construct(string $loginName)
    {
        $this->loginName = $loginName;
    }

    /**
     * @param string $recoverPasswordToken
     */
    public function setRecoverPasswordToken(string $recoverPasswordToken): void
    {
        $this->recoverPasswordToken = $recoverPasswordToken;
    }

    /**
     * @param string $sessionTokenSecretKey
     */
    public function setSessionTokenSecretKey(string $sessionTokenSecretKey): void
    {
        $this->sessionTokenSecretKey = $sessionTokenSecretKey;
    }

    /**
     * @return string Nombre usado para hacer login, normalmente el usuario o el correo.
     */
    public function getLoginName(): string
    {
        return $this->loginName;
    }

    /**
     * @return string Contraseña hasheada.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string Clave secreta de este usuario para codificar el token de sesión.
     */
    public function getSessionTokenSecretKey(): string
    {
        return $this->sessionTokenSecretKey;
    }

    /**
     * @param AuthUserInterface $user
     * @return string
     */
    public function getRecoverPasswordToken(AuthUserInterface $user): string
    {
        $token = new StatelessSessionToken();

        $userId = $user->getId();
        $secretKey = $user->getLoginData()->getSessionTokenSecretKey();

        $token->createToken($userId, $secretKey, 720);
        return $token->getToken();
    }

    /**
     * @return array
     */
    public function getBadLoginAttempts(): array
    {
        return $this->badLoginAttempts;
    }

    /**
     * @param int[] $unixTimes
     */
    public function setBadLoginAttempts(array $unixTimes)
    {
        $this->badLoginAttempts = $unixTimes;
    }

    public function setPassword(string $password)
    {
        $info = password_get_info($password);

        if ($info["algo"] !== PASSWORD_DEFAULT) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->password = $password;
    }

    public function setLoginName(string $loginName)
    {
        $this->loginName = $loginName;
    }


    public function save()
    {

    }
}
