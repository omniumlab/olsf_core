<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/09/2018
 * Time: 12:38
 */

namespace Core\Symfony;


use Core\Config\GlobalConfigInterface;

class RootDirObtainer implements RootDirObtainerInterface
{

    /** @var bool */
    private $isLinux;

    /** @var string */
    private $publicDir;

    function __construct(GlobalConfigInterface $globalConfig)
    {
        $this->isLinux = $globalConfig->isLinux();
        $this->publicDir = $globalConfig->getPublicDir();
    }

    /**
     * @return string
     */
    function getRootDir(): string
    {
        $namespaces = explode("\\", __NAMESPACE__);
        $path = trim(realpath(__DIR__ . str_repeat("/..", count($namespaces) + 7)), "\\\/");

        return ($this->isLinux ? "/" : "") . $path;
    }

    function getUrlBase(): string
    {
        return "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REDIRECT_BASE"];
    }

    /** @return string */
    function getPublicDir(): string
    {
        return $this->getRootDir() . $this->publicDir;

    }
}
