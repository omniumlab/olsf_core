<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/06/2018
 * Time: 18:16
 */

namespace Core\Commands\Symfony;


use Core\Commands\AbstractCommand;
use Core\Commands\QueryCommandInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class QueryBaseCommand extends AbstractCommand implements QueryCommandInterface
{
    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        parent::__construct($request->query->all(), $request->attributes->all(), $request->getMethod(),
                            $request->headers->all());
    }
}