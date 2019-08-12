<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/04/2018
 * Time: 20:19
 */

namespace Core\Text;


use Core\Commands\RequestHeadersInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SymfonyTextHandler implements TextHandlerInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;
    /**
     * @var RequestHeadersInterface
     */
    private $header;

    /**
     * TextHandlerYml constructor.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param RequestHeadersInterface $header
     */
    public function __construct(ContainerInterface $container, RequestHeadersInterface $header)
    {
        $this->container = $container;
        $this->header = $header;
    }


    /**
     * @param string $key
     *
     * @param array $parameters
     *
     * @return mixed|string
     */
    public function get(string $key, $parameters = [])
    {
        if ($this->container->getParameter('default_lang') === $this->header->getHeaderValue('lang')) {
            return $this->searchTranslation($key, $parameters);
        } else if ($this->container->hasParameter($this->header->getHeaderValue('lang'))) {
            $text = $this->getLangParameter($key, $this->header->getHeaderValue('lang'), $parameters);
            if ($text === $key)
                $text = $this->searchTranslation($key, $parameters);
            return $text;
        } else
            return $this->searchTranslation($key, $parameters);
    }

    private function searchTranslation(string $key, $parameters = []): string
    {
        if ($this->container->hasParameter($key)) {
            $text = $this->container->getParameter($key);

            foreach ($parameters as $key => $value) {
                $text = str_replace("##" . $key . "##", $value, $text);
            }

            if (!is_string($text))
                return $key;

            return $text;
        }

        return $key;
    }

    /**
     * @param string $key
     * @param string $lang
     * @param array $parameters
     * @return int|mixed|string
     */
    private function getLangParameter(string $key, string $lang, array $parameters)
    {
        $values = $this->container->getParameter($lang);
        if (array_key_exists($key, $values)) {
            $text = $values[$key];

            foreach ($parameters as $key => $value) {
                $text = str_replace("##" . $key . "##", $value, $text);
            }
            return $text;
        }
        return $key;
    }
}
