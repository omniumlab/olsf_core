<?php


namespace Core\Handlers\ObtainHandlers\FileManager;


use Core\Auth\AuthServiceInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Symfony\RootDirObtainerInterface;
use Core\Text\TextHandlerInterface;
use phpDocumentor\Reflection\File;

abstract class AbstractFileManagerHandler extends Handler
{
    /**
     * @var AuthServiceInterface
     */
    private $authService;
    /**
     * @var RootDirObtainerInterface
     */
    private $rootDirObtainer;

    public function __construct(TextHandlerInterface $textHandler,
                                AuthServiceInterface $authService,
                                RootDirObtainerInterface $rootDirObtainer)
    {
        parent::__construct("GET", false, $textHandler);
        $this->authService = $authService;
        $this->rootDirObtainer = $rootDirObtainer;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        $idUser = $this->authService->getCurrentConnectedUser()->getId();
        $files = $this->getFiles($idUser);

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $files);
    }

    private function getFiles(int $idUser, ?string $folder = ""): array
    {
        $path = $this->rootDirObtainer->getPublicDir() . "/files/file_manager/";
        $this->customizePath($path, $idUser);
        $path .= $folder;

        if (file_exists($path)){
            $files = scandir($path);
            if (in_array("..", $files))
                unset($files[1]);
            unset($files[0]);
        }else
            $files = [];

        foreach ($files as $key => $file){
            if ($this->isFolder($file)){
                $files = [$file => $this->getFiles($idUser, $folder . "/" . $file)] + $files;
                unset($files[$key]);
            }
        }


        return $files;
    }

    protected function customizePath(string &$path, int $idUser){
        $path .= $idUser . "/";
    }

    private function isFolder(string $fileName): bool
    {
        return strpos($fileName, ".") === false;
    }
}
