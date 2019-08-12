<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 05/04/2018
 * Time: 19:48
 */

namespace Core\Controllers\Symfony;


use Core\Exceptions\RestException;
use Core\Handlers\HandlerName;
use Core\Output\Responses\ErrorHandlerResponse;
use Core\Reflection\Finders\CommandBusFinderInterface;
use Core\Reflection\Finders\CommandFinderInterface;
use Core\Resource\ResourceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RestController
 *
 * @package OLSF\RestBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @var \Core\Reflection\Finders\CommandBusFinderInterface
     */
    private $commandBusFinder;
    /**
     * @var \Core\Reflection\Finders\CommandFinderInterface
     */
    private $commandFinder;

    /**
     * RestBaseController constructor.
     *
     * @param \Core\Reflection\Finders\CommandBusFinderInterface $commandBusFinder
     * @param \Core\Reflection\Finders\CommandFinderInterface $commandFinder
     */
    public function __construct(CommandBusFinderInterface $commandBusFinder, CommandFinderInterface $commandFinder)
    {
        $this->commandBusFinder = $commandBusFinder;
        $this->commandFinder = $commandFinder;
    }

    /**
     * @Route("/{resource}")
     * @param $resource
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function doResourceDefaultAction($resource)
    {
        return $this->doResourceAction($resource, "default");
    }

    /**
     * @Route("/{resource}/{action}")
     * @Route("/{resource}/{id}/{action}")
     *
     * @param string $resource
     * @param $action
     *
     * @return JsonResponse
     */
    public function doResourceAction($resource, $action)
    {
        try {
            $resourceName = new ResourceName($resource);
            $handlerName = new HandlerName($action);

            $command = $this->commandFinder->findCommand($resourceName, $handlerName);
            $commandBus = $this->commandBusFinder->findCommandBus($command);

            $response = $commandBus->dispatch($command);
        } catch (\Throwable $exception) {
            $response = $this->getExceptionResponse($exception);
        }

        return new JsonResponse($response->toArray(), $response->getStatusCode(), $response->getHeaders());
    }

    private function getExceptionResponse(\Throwable $exception)
    {
        if (!($exception instanceof RestException)) {
            $exception = RestException::create($exception);
        }

        return new ErrorHandlerResponse($exception->getStatusCode(), $exception->getData(), $exception->getMessage());
    }
}
