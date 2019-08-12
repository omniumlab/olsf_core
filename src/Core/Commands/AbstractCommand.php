<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 23/07/2018
 * Time: 12:06
 */

namespace Core\Commands;


use Core\Exceptions\InputRequiredException;
use Core\Reflection\NameInterface;

abstract class AbstractCommand extends ArrayData implements CommandInterface
{
    /**
     * @var array
     */
    private $urlAttributes;
    /**
     * @var \Core\Reflection\NameInterface
     */
    private $resourceName;
    /**
     * @var \Core\Reflection\NameInterface
     */
    private $actionName;
    /**
     * @var string
     */
    private $httpVerb;
    /**
     * @var array
     */
    private $headers;

    /**
     * AbstractArrayData constructor.
     *
     * @param array $parameters
     * @param array $urlAttributes
     * @param string $httpVerb
     * @param array $headers
     */
    public function __construct(array $parameters, array $urlAttributes, string $httpVerb, array $headers)
    {
        parent::__construct($parameters);

        $this->urlAttributes = $urlAttributes;
        $this->httpVerb = $httpVerb;
        $this->headers = $headers;
    }

    /**
     * @return string El parámetro {id} de la url si existe. Si no existe, devuelve null.
     */
    public function getUrlIdParameter(): ?string
    {
        return array_key_exists("id", $this->urlAttributes) ? $this->urlAttributes["id"] : null;
    }

    public function getAllUrlAttributes(): array
    {
        return $this->urlAttributes;
    }

    public function setUrlAttribute($key, $value)
    {
        $this->urlAttributes[$key] = $value;
    }


    public function getResourceName(): NameInterface
    {
        return $this->resourceName;
    }

    public function getActionName(): NameInterface
    {
        return $this->actionName;
    }

    public function getHttpVerb(): string
    {
        return $this->httpVerb;
    }

    public function setResourceName(NameInterface $name)
    {
        $this->resourceName = $name;
    }

    public function setActionName(NameInterface $name)
    {
        $this->actionName = $name;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader($key, $default = null, $required = false)
    {
        if (!array_key_exists($key, $this->headers)) {
            if ($required) {
                throw new InputRequiredException($key);
            }

            return $default;
        }

        return $this->headers[$key][0];
    }


    public function getLanguageCode(): ?string
    {
        if (!array_key_exists("accept-language", $this->headers)) {
            return null;
        }

        return $this->headers["accept-language"][0];
    }
}