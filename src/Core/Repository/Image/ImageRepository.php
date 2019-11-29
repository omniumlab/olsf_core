<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 01/10/2018
 * Time: 12:27
 */

namespace Core\Repository\Image;


use App\Config\AppGlobalConfigInterface;
use Core\Exceptions\RestException;
use Core\Output\HttpCodes;
use Core\Symfony\RootDirObtainerInterface;
use Core\Symfony\Yaml\YamlParamReaderInterface;

class ImageRepository implements ImageRepositoryInterface
{
    const EXTENSIONS = [
        "jpg",
        "jpeg",
        "png",
        "gif",
    ];

    /** @var  string */
    private $rootPath;


    /** @var AppGlobalConfigInterface */
    private $appGlobalConfig;

    /** @var  int */
    private $minHeight;
    /** @var  int */
    private $minWidth;

    function __construct(RootDirObtainerInterface $rootDirObtainer, AppGlobalConfigInterface $appGlobalConfig)
    {
        $this->rootPath = $rootDirObtainer->getRootDir();
        $this->appGlobalConfig = $appGlobalConfig;
    }

    /**
     * @param string $resource
     * @param int $id
     * @param bool $private
     * @return string
     */
    function getUriDataFromResource(string $resource, int $id, bool $private = false): ?string
    {
        $filePath = $this->getRootPath($private) . $resource . "/" . $resource . "_" . $id;
        return $this->getUriData($filePath);
    }


    private function getRootPath(bool $private){
        return $this->rootPath . ($private ? $this->appGlobalConfig->getImagePrivatePath() : $this->appGlobalConfig->getImagePublicPath());
    }

    function getUriData(string $filePath): ?string
    {
        foreach (self::EXTENSIONS as $ext) {
            $files = glob($filePath . "." . $ext);
            if (!empty($files))
                return $this->encodeFile($files[0]);
        }
        return null;
    }

    /**
     * @param $path string
     * @return string
     */
    private function encodeFile($path){
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    function saveImage(?string $imageName, string $filePath, string $base64, $id = null, $private = false)
    {
        $path = $this->getRootPath($private) . $filePath;
        $directory = rtrim($path, '/');

        if ($imageName === null && $id !== null){
            $pathExploded = explode('/',$directory);
            $lastFolder = end($pathExploded);
            $imageName = $lastFolder . "_" . $id;
        }

        if (!file_exists($directory)){
            $oldmask = umask(0);
            mkdir($directory, 0777, true);
            umask($oldmask);
        }

        $tempPath = tempnam(sys_get_temp_dir(), "olsf");
        $imageType = $this->decodeBase64($base64, $tempPath);
        $this->checkResolution($tempPath);

        $this->deleteExistingFiles($directory, $imageName);
        $this->moveTempFileToPath($tempPath, $directory."/".$imageName.".".$imageType);
    }

    /**
     * @param $base64 string
     * @param $file string
     * @return string Image type
     */
    private function decodeBase64($base64, $file){
        $image_parts = explode(";base64,", $base64);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        file_put_contents($file, $image_base64);
        chmod($file, 0777);

        return $image_type;
    }

    private function checkResolution($path){
        $sizes = getimagesize($path);

        if ($sizes[0] < $this->minWidth && $sizes[1] < $this->minHeight){
            throw new RestException(HttpCodes::CODE_BAD_REQUEST,
                "The resolution of the image must be equal to or greater than " . $this->minWidth . "x" . $this->minHeight);
        }
        if ($sizes[0] < $this->minWidth){
            throw new RestException(HttpCodes::CODE_BAD_REQUEST, "The witdh of the image must be greater than " . $this->minWidth . "px");
        }
        if ($sizes[1] < $this->minHeight){
            throw new RestException(HttpCodes::CODE_BAD_REQUEST, "The height of the image must be greater than " . $this->minHeight . "px");
        }
    }



    private function deleteExistingFiles($directory, $fileName)
    {
        $files = glob($directory . "/" . $fileName . ".*");

        foreach ($files as $file){
            unlink($file);
        }
    }

    private function moveTempFileToPath($tempPath, $newPath){
        rename($tempPath, $newPath);
    }

    /**
     * @param int $minHeight
     */
    public function setMinHeight(int $minHeight)
    {
        $this->minHeight = $minHeight;
    }

    /**
     * @param int $minWidth
     */
    public function setMinWidth($minWidth)
    {
        $this->minWidth = $minWidth;
    }
}
