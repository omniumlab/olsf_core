<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 28/01/2019
 * Time: 10:59
 */

namespace Core\Handlers\LangHandler;


use Core\Auth\Roles\RoleInterface;
use Core\Handlers\Handler;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractLangHandler extends Handler
{

    /**
     * @var string
     */
    private $apiUrlPrefix;
    private $container;

    /**
     * Handler constructor.
     *
     * @param string $restUrlPrefix
     * @param ContainerInterface $container
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(string $restUrlPrefix, ContainerInterface $container,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct("GET", false, $textHandler);

        $this->container = $container;
        $this->apiUrlPrefix = $restUrlPrefix;
        $this->getPermission()->setNotRevocable();

    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();
        $config = [
            "default_lang" => $this->container->getParameter("default_lang"),
        ];

        return new SuccessHandlerResponse(200, $config);
    }

    protected function getApiUrlPrefix()
    {
        return $this->apiUrlPrefix;
    }

}
