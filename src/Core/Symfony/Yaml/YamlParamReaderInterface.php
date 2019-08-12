<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/02/2018
 * Time: 10:42
 */

namespace Core\Symfony\Yaml;


interface YamlParamReaderInterface
{
    /**
     * @param $filePath string File path
     * @param $parameter string Parameter name in .yml
     * @return mixed Value of the param
     */
    public function getParameter($filePath, $parameter);

    /**
     * Obtiene todos los parámetros del .yml
     *
     * @param string $filePath File path from the "/app" folder.
     * @return array All params
     */
    public function getAllParameters(string $filePath): array;
}