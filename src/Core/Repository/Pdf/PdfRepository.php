<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 18/01/2019
 * Time: 15:11
 */

namespace Core\Repository\Pdf;


use Core\Exceptions\RestException;
use Core\Output\HttpCodes;
use Imagick;

class PdfRepository implements PdfRepositoryInterface
{

    function __construct()
    {
        //$this->checkImagickInstalled();
    }

    private function checkImagickInstalled()
    {
        if (!extension_loaded('imagick')) {
            throw new RestException(HttpCodes::CODE_INTERNAL_SERVER_ERROR,
                "You must install Imagick and GhostScript on the server before using this service.");
        }
    }

    function getImageFromPdf(string $pdfPath): string
    {
        $img = new Imagick();
        $img->setResolution(300, 300);
        $img->readImage($pdfPath);
        $img->resetIterator();
        $img = $img->appendImages(true);
        $img = $img->flattenImages();
        $img->setImageCompressionQuality(100);
        $img->setImageFormat('jpeg');

        return 'data:image/jpg;base64,' . base64_encode($img->getImageBlob());
    }


}