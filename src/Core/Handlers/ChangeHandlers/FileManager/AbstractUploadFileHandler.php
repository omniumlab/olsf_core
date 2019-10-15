<?php


namespace Core\Handlers\ChangeHandlers\FileManager;


use Core\Auth\AuthServiceInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Repository\File\FileRepositoryInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractUploadFileHandler extends Handler
{
    /**
     * @var FileRepositoryInterface
     */
    private $fileRepository;
    /**
     * @var AuthServiceInterface
     */
    private $authService;

    public function __construct(TextHandlerInterface $textHandler,
                                FileRepositoryInterface $fileRepository,
                                AuthServiceInterface $authService)
    {
        parent::__construct("POST", false, $textHandler);
        $this->fileRepository = $fileRepository;
        $this->authService = $authService;
    }

    public function handle($command): HandlerResponseInterface
    {
        $folder = "file_manager";
        $this->customizePath($folder, $this->authService->getCurrentConnectedUser()->getId());
        $folder .= $command->get("path", null, true);

        $fileName = $command->get("filename");

        $this->fileRepository->uploadResourceByCommand($command, $folder, null, $fileName);
        return new SuccessHandlerResponse(HttpCodes::CODE_OK);
    }

    protected function customizePath(string &$path, int $idUser){
        $path .=  "/" . $idUser;
    }
}
