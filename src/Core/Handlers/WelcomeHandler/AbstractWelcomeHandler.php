<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/04/2019
 * Time: 9:57
 */

namespace Core\Handlers\WelcomeHandler;


use Core\Auth\Roles\RoleInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractWelcomeHandler extends Handler
{

    private $container;
    private $apiUrlPrefix;

    /**
     * @param string $restUrlPrefix
     * @param ContainerInterface $container
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(string $restUrlPrefix, ContainerInterface $container, TextHandlerInterface $textHandler)
    {
        parent::__construct("GET", false, $textHandler);
        $this->container = $container;
        $this->apiUrlPrefix = $restUrlPrefix;
        $this->getPermission()->setNotRevocable();
    }

    public function handle($command): HandlerResponseInterface
    {
       return new SuccessHandlerResponse(HttpCodes::CODE_OK,[]);
    }


}