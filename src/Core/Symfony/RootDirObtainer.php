<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/09/2018
 * Time: 12:38
 */

namespace Core\Symfony;


use Core\Config\GlobalConfigInterface;
use Core\Exceptions\RestException;
use Symfony\Component\HttpKernel\KernelInterface;

class RootDirObtainer implements RootDirObtainerInterface
{

    /** @var bool */
    private $isLinux;

    /** @var string */
    private $publicDir;
    /**
     * @var KernelInterface
     */
    private $kernel;

    function __construct(GlobalConfigInterface $globalConfig, KernelInterface $kernel)
    {
        $this->isLinux = $globalConfig->isLinux();
        $this->publicDir = $globalConfig->getPublicDir();
        $this->kernel = $kernel;
    }

    /**
     * @return string
     */
    function getRootDir(): string
    {
//$path =  trim($this->kernel->getRootDir(), "\\\/") ;
        //$path = trim(realpath(__DIR__ . str_repeat("/..",  7)), "\\\/");
        $path = $this->kernel->getRootDir() . str_repeat("/..", 2);

        return $path;
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
