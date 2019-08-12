<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 13/07/2018
 * Time: 19:33
 */

namespace Core\Output\Responses;


use Core\Auth\Session\SessionTokenInterface;

class ApiLoginResponse extends SuccessHandlerResponse
{
    /**
     * @var \Core\Auth\Session\SessionTokenInterface
     */
    private $token;

    public function __construct(SessionTokenInterface $token)
    {
        parent::__construct(200, ["session_token" => $token->getToken()]);

        $this->token = $token;
    }

    /**
     * @return \Core\Auth\Session\SessionTokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }

}