<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 16/11/2017
 * Time: 17:21
 */

namespace Core\Fields\Output;


use Core\Commands\RequestHeadersInterface;
use Core\Repository\Translation\TranslationRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SymfonyTraducibleText extends Text
{

    /** @var TranslationRepositoryInterface */
    private $translationRepository;

    /** @var bool */
    private $translateAllWords;
    /** @var string */
    private $table;

    public function __construct(string $fieldName, TranslationRepositoryInterface $translationRepository, string $alias = null, bool $translateAllWords = false)
    {
        $this->translationRepository = $translationRepository;
        $this->translateAllWords = $translateAllWords;
        $this->table = explode(".", $fieldName)[0];
        parent::__construct($fieldName, $alias);
    }

    public function formatValue($value)
    {
        return $this->translationRepository->getTraduction($value, $this->table, $this->translateAllWords);
    }

    public function compareValues($valueTranslate)
    {
        return $this->translationRepository->getOriginalKeys($valueTranslate, $this->translationRepository->getLang(), $this->table);
    }

    /**
     * @return bool
     */
    public function isTranslateAllWords(): bool
    {
        return $this->translateAllWords;
    }

    public function isDefaultLang(): bool
    {
        return $this->translationRepository->isDefaultLang($this->translationRepository->getDefaultLang(), $this->translationRepository->getLang());
    }

    public function translateRepository()
    {
        return $this->translationRepository;
    }

}
