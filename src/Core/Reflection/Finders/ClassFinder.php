<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/04/2018
 * Time: 21:29
 */

namespace Core\Reflection\Finders;


use Core\Symfony\RootDirObtainerInterface;

class ClassFinder implements ClassFinderInterface
{

    /** @var RootDirObtainerInterface  */
    private $rootDirObtainer;

    function __construct(RootDirObtainerInterface $rootDirObtainer)
    {
        $this->rootDirObtainer = $rootDirObtainer;
    }

    public function getAllClasses($namespace, string $superClass = '')
    {
        $directory = str_replace("\\", DIRECTORY_SEPARATOR, $this->getNamespaceDir($namespace));
        $files = glob($directory . DIRECTORY_SEPARATOR . "*.php");

        $classes = [];

        foreach ($files as $file) {
            $className = $namespace . "\\" . substr(basename($file), 0, -4);

            try {
                $reflection = new \ReflectionClass($className);

                if (empty($superClass) || $reflection->isSubclassOf($superClass)) {
                    $classes[] = $className;
                }
            } catch (\ReflectionException $e) {
            }
        }

        return $classes;
    }

    private function getNamespaceDir($namespace)
    {
        $rootDir = $this->getRootDir() . DIRECTORY_SEPARATOR . "src";

        return str_replace("\\", DIRECTORY_SEPARATOR, $rootDir . DIRECTORY_SEPARATOR . $namespace);
    }

    protected function getRootDir()
    {
        return $this->rootDirObtainer->getRootDir();
    }
}