<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 06/02/2018
 * Time: 10:03
 */

namespace Core\Fields\Output\Yaml;


use Core\Fields\Output\OutputFieldBase;
use Core\Symfony\Yaml\YamlParamReaderInterface;

class TextYaml extends OutputFieldBase
{
    /**
     * @var string
     */
    private $filePath;
    /**
     * @var string
     */
    private $parameterName;
    /**
     * @var YamlParamReaderInterface
     */
    private $yamlParamReader;

    public function __construct($name, YamlParamReaderInterface $yamlParamReader, $filePath, $parameterName, $alias = null)
    {
        parent::__construct($name, $alias);
        $this->filePath = $filePath;
        $this->parameterName = $parameterName;
        $this->yamlParamReader = $yamlParamReader;
    }

    public function formatValue($value)
    {
        return $this->yamlParamReader->getParameter($this->filePath, $this->parameterName);
    }


}