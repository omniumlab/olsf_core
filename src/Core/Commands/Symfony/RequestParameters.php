<?php


namespace Core\Commands\Symfony;


use Core\Commands\RequestParametersInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestParameters implements RequestParametersInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    function get(string $name, $default = null)
    {
        return $this->requestStack->getCurrentRequest()->get($name, $default);
    }
}
