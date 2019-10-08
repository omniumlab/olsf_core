<?php


namespace Core\Handlers\ObtainHandlers\FileManager;


use Core\Auth\AuthServiceInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Symfony\RootDirObtainerInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractCreateFolderHandler extends Handler
{

    /**
     * @var RootDirObtainerInterface
     */
    private $rootDirObtainer;
    /**
     * @var AuthServiceInterface
     */
    private $authService;

    public function __construct(TextHandlerInterface $textHandler,
                                RootDirObtainerInterface $rootDirObtainer,
                                AuthServiceInterface $authService)
    {
        parent::__construct("POST", false, $textHandler);
        $this->rootDirObtainer = $rootDirObtainer;
        $this->authService = $authService;
    }

    public function handle($command): HandlerResponseInterface
    {
        $idUser = $this->authService->getCurrentConnectedUser()->getId();
        $userPath = $command->get("path", null, true);

        $path = $this->rootDirObtainer->getPublicDir() . "/files/file_manager/";
        $this->customizePath($path, $idUser);
        $path .= $userPath;

        mkdir($path, 0777, true);

        return new SuccessHandlerResponse(HttpCodes::CODE_OK);
    }

    protected function customizePath(string &$path, int $idUser){
        $path .= $idUser;
    }
}
