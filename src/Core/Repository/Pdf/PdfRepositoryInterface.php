<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 18/01/2019
 * Time: 15:10
 */

namespace Core\Repository\Pdf;


interface PdfRepositoryInterface
{
    /**
     * @param string $pdfPath
     * @return string base64 string
     */
    function getImageFromPdf(string $pdfPath): string;
}