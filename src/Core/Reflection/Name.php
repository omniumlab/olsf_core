<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2018
 * Time: 18:36
 */

namespace Core\Reflection;

class Name implements NameInterface
{
    private $camelCase;
    private $snakeCase;
    /**
     * @var string
     */
    private $suffix;

    /**
     * Name constructor.
     *
     * @param string|object $name
     * @param string $suffix
     */
    public function __construct($name, string $suffix = '')
    {
        if (is_object($name) || strpos($name, "\\") !== false) {
            $name = $this->getNameFromObject($name, $suffix);
        }

        if ($name === null) {
            throw new \InvalidArgumentException("name cannot be null");
        }

        if ($this->isCamelCase($name)) {
            $this->camelCase = $name;
            $this->snakeCase = $this->createSnakeCase();
        } else {
            $this->snakeCase = $name;
            $this->camelCase = $this->createCamelCase();
        }
        $this->suffix = $suffix;
    }

    private function getNameFromObject($object, string $suffix)
    {
        try {
            $reflection = new \ReflectionClass($object);
            $shortName = $reflection->getShortName();

            if ($suffix) {
                return substr($shortName, 0, -strlen($suffix));
            }

            return $shortName;

        } catch (\ReflectionException $e) {
            return null;
        }


    }

    private function isCamelCase($name): bool
    {
        return !ctype_upper($name) && !!preg_match("#^[A-Z][A-Za-z0-9]*$#", $name);
    }

    private function createSnakeCase()
    {
        return strtolower(preg_replace("#([a-z0-9])([A-Z])#", "$1_$2", $this->camelCase));
    }

    private function createCamelCase()
    {
        return str_replace(" ", "", ucwords(str_replace(["_", "-"], " ", strtolower($this->snakeCase))));
    }

    /**
     * @param bool $suffix
     *
     * @return string
     */
    public function getCamelCase(bool $suffix = true): string
    {
        $result = $this->camelCase;

        if ($suffix) {
            $result .= $this->suffix;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getSnakeCase(): string
    {
        return $this->snakeCase;
    }


}