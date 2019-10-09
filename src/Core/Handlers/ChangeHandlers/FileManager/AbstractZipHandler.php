<?php


namespace Core\Handlers\ChangeHandlers\FileManager;


use Core\Auth\AuthServiceInterface;
use Core\Config\GlobalConfigInterface;
use Core\Exceptions\RestException;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Symfony\RootDirObtainerInterface;
use Core\Text\TextHandlerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use ZipArchive;

abstract class AbstractZipHandler extends Handler
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
                                RootDirObtainerInterface $rootDirObtainer,
                                AuthServiceInterface $authService)
    {
        parent::__construct("POST", false, $textHandler);
        $this->authService = $authService;
        $this->rootDirObtainer = $rootDirObtainer;
    }

    public function handle($command): HandlerResponseInterface
    {
        $files = explode(",", $command->get("file_paths", null, true));
        $where = $command->get("zip_path", null, true);

        $folder = "/files/file_manager";
        $this->customizePath($folder, $this->authService->getCurrentConnectedUser()->getId());
        $rootPath = $this->rootDirObtainer->getPublicDir() . $folder;

        $zipPath = $rootPath . $where;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE){
            foreach ($files as $file){
                $filePath = $rootPath . $file;
                if (!is_dir($filePath))
                    $zip->addFile($rootPath . $file, basename($file));
                else{
                    $this->addDirToZip($zip, $filePath);
                }
            }

            $zip->close();
        }
        if(!file_exists($zipPath))
            throw new RestException(HttpCodes::CODE_CONFLICT, "Zip not created");

        return new SuccessHandlerResponse(HttpCodes::CODE_OK);
    }

    private function addDirToZip(ZipArchive $zip, string $rootPath)
    {
        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = basename($rootPath) . "/" . substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    protected function customizePath(string &$path, int $idUser){
        $path .=  "/" . $idUser;
    }
}
