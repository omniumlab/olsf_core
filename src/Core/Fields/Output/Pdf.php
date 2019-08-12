<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 18/01/2019
 * Time: 13:26
 */

namespace Core\Fields\Output;


use Core\Repository\Pdf\PdfRepositoryInterface;
use Core\Symfony\RootDirObtainerInterface;
use Imagick;

class Pdf extends OutputFieldBase implements DependentFieldInterface
{
    /** @var string */
    private $rootDir;

    /** @var  string */
    private $fieldDependent;

    /** @var PdfRepositoryInterface */
    private $pdfRepository;

    public function __construct($name, string $resource, string $fieldDependent,
                                RootDirObtainerInterface $rootDirObtainer,
                                PdfRepositoryInterface $pdfRepository,
                                $alias = null)
    {
        parent::__construct($name, $alias);
        $this->fieldDependent = $fieldDependent;
        $this->pdfRepository = $pdfRepository;
        $this->rootDir = $rootDirObtainer->getPublicDir();
        $this->rootDir .= "/pdf/" . $resource . "/" . $resource . "_";
    }

    public function getPdfImage(int $resourceId)
    {
         return ["image" => $this->pdfRepository->getImageFromPdf($this->rootDir . $resourceId . ".pdf")];
    }


    function getFieldDependent(): ?string
    {
        return $this->fieldDependent;
    }

    public function getType()
    {
        return "image";
    }
}
