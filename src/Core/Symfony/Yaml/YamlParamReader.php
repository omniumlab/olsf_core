<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 31/01/2018
 * Time: 16:34
 */

namespace Core\Symfony\Yaml;


use Core\Exceptions\RestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Parser;

class YamlParamReader implements YamlParamReaderInterface
{
    /**
     * @var string
     */
    private $rootDir;

    public function __construct(KernelInterface $kernel)
    {
        $this->rootDir = $kernel->getRootDir();
    }

    /**
     * @param $filePath string File path from the "/app" folder.
     * @param $parameter string Parameter name in .yml
     * @return mixed Value of the param
     * @throws RestException
     */
    public function getParameter($filePath, $parameter)
    {
        $path = $this->rootDir . $filePath;
        $result = (new Parser())->parse(file_get_contents($path));

        if (!in_array("parameters", array_keys($result))){
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR,
                "The yaml file '" . $filePath . "' not contains 'parameters' node. You need to include in");
        }

        $parameters = $result["parameters"];

        if (!in_array($parameter, array_keys($parameters))){
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR,
                "The parameter '" . $parameter . "' not exist in '" . $filePath . "'");
        }

        return $parameters[$parameter];
    }

    /**
     * Obtiene todos los parámetros del .yml
     *
     * @param string $filePath File path from the "/app" folder.
     * @return array All params
     */
    public function getAllParameters(string $filePath): array
    {
        $path = $this->rootDir . $filePath;

        return !file_exists($path) ? [] : (new Parser())->parse(file_get_contents($path));
    }
}