<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 07/02/2018
 * Time: 13:30
 */

namespace Core\Fields\Output;

use Core\Repository\Image\ImageRepositoryInterface;
use Core\Symfony\RootDirObtainerInterface;
use Core\Symfony\Yaml\YamlParamReaderInterface;

class UriData extends OutputFieldBase implements DependentFieldInterface
{

    /**
     * @var string
     */
    private $resource;

    /**
     * @var string|null
     */
    private $fieldDependent;

    /** @var ImageRepositoryInterface  */
    private $imageRepository;

    /** @var bool */
    private $private;

    public function __construct(ImageRepositoryInterface $imageRepository, string $name, string $resource, $identifierFieldName = null, $private = false, $alias = null)
    {
        parent::__construct($name, $alias);
        $this->fieldDependent = $identifierFieldName;
        $this->imageRepository = $imageRepository;
        $this->imageRepository = $imageRepository;
        $this->private = $private;
        $this->resource = $resource;
    }


    public function getUriData($id){
        return $this->imageRepository->getUriDataFromResource($this->resource, $id, $this->private);
    }

    public function getType()
    {
        return "image";
    }

    function getFieldDependent(): ?string
    {
        return $this->fieldDependent;
    }
}
