<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/02/2018
 * Time: 11:34
 */

namespace Core\Fields\Input;


use Core\Exceptions\RestException;
use Core\Repository\Image\ImageRepositoryInterface;
use Core\Symfony\RootDirObtainerInterface;
use Core\Symfony\Yaml\YamlParamReader;
use Core\Symfony\Yaml\YamlParamReaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class SymfonyBaseImage extends BaseInputField implements InputFieldInterface
{
    /** @var ImageRepositoryInterface  */
    private $imageRepository;

    /** @var null|string  */
    private $imageName;

    /** @var bool */
    private $private;

    /** @var string */
    private $path;

    /**
     * BaseImage constructor.
     * @param ImageRepositoryInterface $imageRepository
     * @param string $name Field name
     * @param string $path Path after the public or private folder.
     * @param null|string $modelClassName Model of the table to which the image belongs.
     * @param bool $private
     * @param null $imageName
     * @param string $inputKeyName
     */
    public function __construct(ImageRepositoryInterface $imageRepository, $name, $path, $modelClassName, $private = false, $imageName = null, $inputKeyName = '')
    {
        parent::__construct($name, $inputKeyName, $modelClassName);
        $this->setType("image");
        $this->imageRepository = $imageRepository;
        $this->imageName = $imageName;
        $this->private = $private;
        $this->path = $path;
    }

    public function saveImage($base64, $id = null)
    {
        $this->imageRepository->saveImage($this->imageName, $this->path, $base64, $id, $this->private);
    }

    /**
     * @param int $minHeight
     */
    public function setMinHeight(int $minHeight)
    {
        $this->imageRepository->setMinHeight($minHeight);
    }

    /**
     * @param int $minWidth
     */
    public function setMinWidth($minWidth)
    {
        $this->imageRepository->setMinWidth($minWidth);
    }
}