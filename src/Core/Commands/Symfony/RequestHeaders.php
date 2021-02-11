<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/07/2018
 * Time: 21:02
 */

namespace Core\Commands\Symfony;


use App\Propel\UserQuery;
use Core\Auth\Session\StatelessSessionToken;
use Core\Auth\User\AnonymousUser;
use App\User\UserProvider;
use Core\Auth\User\UserProviderInterface;
use Core\Commands\RequestHeadersInterface;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestHeaders implements RequestHeadersInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;


    /**
     * RequestHeaders constructor.
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();

    }


    /**
     * @param string $name
     *
     * @return array|string
     */
    public function getHeaderValue(string $name)
    {
        return $this->request->headers->get($name);
    }

    /**
     * @param string $name
     *
     * @return array|string
     */
    public function setHeaderValue(string $name, $value)
    {
        return $this->request->headers->set($name, $value);
    }

}