<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/08/2018
 * Time: 8:57
 */

namespace Core\Language\Repository;


use Core\Enums\Identifier\Repository\YamlEnumIdentifierRepository;
use Core\Language\Factory\LanguageFactoryInterface;
use Core\Language\LanguageInterface;

class LanguageRepository implements LanguageRepositoryInterface
{
    private $languages = [];
    /**
     * @var \Core\Language\Factory\LanguageFactoryInterface
     */
    private $languageFactory;
    /**
     * @var LanguageInterface
     */
    private $default;

    /**
     * LanguageRepository constructor.
     *
     * @param \Core\Language\Factory\LanguageFactoryInterface $languageFactory
     */
    public function __construct(LanguageFactoryInterface $languageFactory)
    {
        $this->languageFactory = $languageFactory;
        $this->addAll();
    }

    private function addAll()
    {
        $languages = new YamlEnumIdentifierRepository("languages");

        foreach ($languages->all() as $code => $id) {
            if (array_key_exists($code, $this->languages)) {
                throw new \InvalidArgumentException("Duplicated language " . $code . " in languages.yml");
            }

            $this->add($code, $id);
        }

        $this->addShortVersions();
    }

    private function add(string $code, int $id)
    {
        $language = $this->languageFactory->make($id);

        if (empty($this->languages)) {
            $language->setDefault(true);
            $this->default = $language;
        }

        $this->languages[$code] = $language;
    }

    private function addShortVersions()
    {
        foreach ($this->languages as $code => $language) {
            if (strlen($code) > 2) {
                $shortCode = substr($code, 0, 2);

                if (!array_key_exists($shortCode, $this->languages)) {
                    $this->languages[$shortCode] = $language;
                }
            }
        }
    }

    public function getByCode(?string $code): LanguageInterface
    {
        $code = $this->cleanCode($code);

        if ($code === null || !array_key_exists($code, $this->languages)) {
            return reset($this->languages);
        }

        return $this->languages[$code];
    }

    private function cleanCode(?string $code)
    {
        if ($code === null) {
            return null;
        }

        if (strlen($code) === 2) {
            return $code;
        }

        return strtolower(substr($code, 0, 2) . "_" . substr($code, -2));
    }

    /**
     * @return \Core\Language\LanguageInterface
     */
    public function getDefault(): LanguageInterface
    {
        return $this->default;
    }
}