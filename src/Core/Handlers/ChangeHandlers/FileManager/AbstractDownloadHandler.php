<?php


namespace Core\Handlers\ChangeHandlers\FileManager;


use Core\Auth\AuthServiceInterface;
use Core\Config\GlobalConfigInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Symfony\RootDirObtainerInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractDownloadHandler extends Handler
{
    /**
     * @var GlobalConfigInterface
     */
    private $appConfig;
    /**
     * @var RootDirObtainerInterface
     */
    private $rootDirObtainer;
    /**
     * @var AuthServiceInterface
     */
    private $authService;

    public function __construct(TextHandlerInterface $textHandler, GlobalConfigInterface $appConfig,
                                RootDirObtainerInterface $rootDirObtainer,
                                AuthServiceInterface $authService)
    {
        parent::__construct("GET", false, $textHandler);

        $this->appConfig = $appConfig;
        $this->rootDirObtainer = $rootDirObtainer;
        $this->authService = $authService;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function handle($command): HandlerResponseInterface
    {
        $relativePath = $command->get("path", null, true);
        $fileName = $command->get("file_name", null, true);
        $file = basename($relativePath);

        $exploded = explode(".", $file);
        $fileType = strtolower($exploded[1]);

        $path =  $this->appConfig->getHttp() . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REDIRECT_BASE"]
            . "/files/file_manager";
        $this->customizePath($path);
        $path .= $relativePath;

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [
            "name" => $fileName . "." . $fileType,
            "url" => $path,
            "mime_type" => $this->getMimeType($relativePath)
        ], $this->getTextHandler()->get("download_success"));
    }

    private function customizePath(string &$path)
    {
        $idUser = $this->authService->getCurrentConnectedUser()->getId();
        $path .= "/" . $idUser;
    }


    private function getMimeType(string $path): string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $rootPath = $this->rootDirObtainer->getPublicDir() . "/files/file_manager";
        $this->customizePath($rootPath);

        $mimeType = finfo_file($finfo, $rootPath . $path);
        finfo_close($finfo);
        return $mimeType;
    }
}
