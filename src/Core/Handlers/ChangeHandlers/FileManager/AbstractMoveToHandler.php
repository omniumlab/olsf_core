<?php


namespace Core\Handlers\ChangeHandlers\FileManager;


use Core\Auth\AuthServiceInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Repository\File\FileRepositoryInterface;
use Core\Symfony\RootDirObtainerInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractMoveToHandler extends Handler
{
    /**
     * @var FileRepositoryInterface
     */
    private $fileRepository;
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
                                AuthServiceInterface $authService,
                                FileRepositoryInterface $fileRepository)
    {
        parent::__construct("PUT", false, $textHandler);
        $this->authService = $authService;
        $this->rootDirObtainer = $rootDirObtainer;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function handle($command): HandlerResponseInterface
    {
        $filePath = $command->get("file_path", null, true);
        $newDirectory = $command->get("new_path", null, true);

        $rootPath = $this->rootDirObtainer->getPublicDir() . "/files/file_manager";
        $this->customizePath($rootPath, $this->authService->getCurrentConnectedUser()->getId());

        $this->fileRepository->moveFile($rootPath . $filePath, $rootPath . $newDirectory);

        return new SuccessHandlerResponse(HttpCodes::CODE_OK);
    }

    protected function customizePath(string &$path, int $idUser){
        $path .=  "/" . $idUser;
    }
}
