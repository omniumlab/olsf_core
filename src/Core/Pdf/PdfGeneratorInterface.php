<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 17/01/2019
 * Time: 11:28
 */

namespace Core\Pdf;


interface PdfGeneratorInterface
{
    /**
     * @param string $resource Nombre del recurso que se utilizará para la carpeta y el PDF.
     * @param string $templateName Nombre del template Html con el que se creará el PDF
     * @param int|null $id Id que se concatenará al nombre del pdf si no es null
     * @param array $parameters Parámetros que se utilizarán en el Template si tiene.
     */
    function generate(string $resource, string $templateName, int $id = null, array $parameters = []);
}