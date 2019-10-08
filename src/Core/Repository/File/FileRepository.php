<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 16/04/2019
 * Time: 16:06
 */

namespace Core\Repository\File;


use Core\Commands\CommandInterface;
use Core\Exceptions\RestException;
use Core\Output\HttpCodes;
use Core\Symfony\RootDirObtainerInterface;

class FileRepository implements FileRepositoryInterface
{

    /** @var RootDirObtainerInterface */
    private $rootDirObtainer;

    public function __construct(RootDirObtainerInterface $rootDirObtainer)
    {
        $this->rootDirObtainer = $rootDirObtainer;
    }

    function saveInResource(string $base64, string $folderName, string $fileName)
    {
        $path = $this->getResourcePath($folderName);

        $this->saveFile($base64,$path . "/" . $fileName);
    }

    function save(string $base64, string $path)
    {
        $this->saveFile($base64, $path);
    }

    private function saveFile(string $base64, string $path)
    {
        $savePath = $this->rootDirObtainer->getRootDir() . $path;

        $binary = base64_decode(explode(",", $base64, 2)[1]);
        file_put_contents($savePath, $binary);
    }

    /**
     * @param string $folder Nombre de la carpeta donde se buscará los archivos dentro de la carpeta "files".
     * @param int|null $offset
     * @param int|null $limit
     * @param string[] $extensions Filtro de extensiones para que solo busque las seleccionadas
     * @param string|null $nameFilter
     * @param bool $withDirControl
     * @return string[]
     */
    function getFiles(string $folder, ?int $offset = 0, ?int $limit = 0, array $extensions = [], ?string $nameFilter = null, bool $withDirControl = false): array
    {
        $path = $this->rootDirObtainer->getPublicDir() . "/files/" . $folder;

        if (empty($extensions))
            $files = scandir($path);
        else
            $files = preg_grep('~\.(' . implode("|", $extensions) . ')$~', scandir($path));

        if (!$withDirControl){
            unset($files[0]);
            unset($files[1]);
        }

        if (!empty($files))
            $files = $this->orderFilesDesc($files, $path);

        if ($nameFilter !== null)
            $this->filterFiles($nameFilter, $files);

        $files = empty($files) ? [] : array_slice($files, $offset, $limit);
        return $files;
    }

    private function orderFilesDesc(array $files, string $path): array
    {
        $orderFiles = [];
        foreach ($files as $file) {
            $orderFiles[$file] = filemtime($path . '/' . $file);
        }
        arsort($orderFiles);
        return array_keys($orderFiles);
    }

    private function filterFiles(string $filter, array &$files)
    {
        foreach ($files as $index => $file)
            if (!(strpos($file, $filter) !== false))
                unset($files[$index]);
    }

    function deleteFile(string $path)
    {
        unlink($path);
    }

    function uploadResourceByCommand(CommandInterface $command, string $folderName, ?int $id = null, ?string $fileName = null)
    {
        if ($id !== null)
            $folderName .= "/" . $id;

        $path = $this->getResourcePath($folderName);
        $file = $_FILES["file"];

        if ($fileName === null)
            $fileName = basename($file['name']);


        if (!move_uploaded_file($file['tmp_name'], $path . "/" . $fileName)) {
            throw new RestException(HttpCodes::CODE_CONFLICT, "Too many files uploaded");
        }
    }

    private function getResourcePath(string $folderName): string
    {
        $folder = "/files/" . $folderName;
        $absolutePath = $this->rootDirObtainer->getPublicDir() . $folder;
        if (!file_exists($absolutePath))
            mkdir($absolutePath, 0777, true);

        return $absolutePath;
    }

    function moveFile(string $filePath, string $newPath)
    {
        if (file_exists($filePath)){
            if (!file_exists($newPath))
                mkdir($newPath, 0777, true);

            $fileName = basename($filePath);

            rename($filePath, $newPath . "/" . $fileName);
        }
    }

    function renameFile(string $filePath, string $newName)
    {
        if (file_exists($filePath)){
            $fileName = basename($filePath);
            $path = str_replace($fileName, "", $filePath);
            rename($filePath, $path . $newName);
        }
    }


}
