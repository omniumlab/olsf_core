<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/06/2018
 * Time: 18:15
 */

namespace Core\Commands\Symfony;


use Core\Commands\AbstractCommand;
use Core\Commands\RequestCommandInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestBaseCommand extends AbstractCommand implements RequestCommandInterface
{
    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        $data = array_merge($request->request->all(), $request->query->all());
        parent::__construct($data, $request->attributes->all(), $request->getMethod(), $request->headers->all());
    }
}