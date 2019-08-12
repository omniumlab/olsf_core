<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 24/01/2019
 * Time: 13:39
 */

namespace Core\Repository\Translation;


use Core\Commands\RequestHeadersInterface;
use Core\Config\GlobalConfigInterface;
use PDO;
use Propel\Runtime\Propel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Translator;

class SymfonyTranslationRepository implements TranslationRepositoryInterface
{
    /**
     * @var Translator
     */
    private $translator;

    /** @var GlobalConfigInterface */
    private $globalConfig;

    /** @var RequestHeadersInterface */
    private $headers;

    public function __construct(GlobalConfigInterface $globalConfig, RequestHeadersInterface $headers)
    {
        $this->globalConfig = $globalConfig;
        $this->headers = $headers;
    }

    function getTraduction(?string $key, string $table = null, bool $translateAllWords = false): ?string
    {
        $locale = $this->getLang();
        $this->createTranslator($locale);
        if ($translateAllWords) {
            foreach (str_word_count($key, 1) as $word) {
                $key = str_replace($word, $this->translator->trans($word, [], $table, $locale), $key);
            }
            return $key;
        } else {
            $translate = $this->translator->trans($key, [], $table, $locale);
            return $translate !== "" && $translate !== null ? $translate : $key;

        }
    }

    public function getOriginalKeys(string $valueTranslate, string $locale, string $table, bool $translateAllWords = false): array
    {
        $this->createTranslator($locale);
        return array_values(array_flip(preg_grep('/^' . $valueTranslate . '(\w+)?/i', $this->translator->getCatalogue()->all($table))));
    }

    /**
     * @param string $locale
     */
    public function createTranslator(string $locale): void
    {
        $this->translator = new Translator($locale);
        $this->checkAllKeyValues();
    }

    function isDefaultLang(string $locale, string $default_lang): bool
    {
        return $locale == $default_lang;
    }

    function getLanguages(): array
    {
        return $this->globalConfig->getAvailableLang();
    }

    function getAllKeyValue(): array
    {
        $this->createTranslator($this->globalConfig->getDefaultLang());

        return $this->translator->getCatalogue()->all();
    }


    private function checkAllKeyValues()
    {

        foreach ($this->getTablesName() as $table) {
            $this->checkTable($table);
            $this->createJson($table, $this->globalConfig->getAvailableLang());
        }


    }

    private function createJson($table, array $getAvailableLang)
    {
        $pathTraductions = $this->globalConfig->getTranslatePath();
        foreach ($getAvailableLang as $a) {
            if ($this->getDefaultLang() !== $a) {
                $path = $pathTraductions . '/' . $table . '/' . $a . '.json';
                if (!file_exists($path)) {
                    file_put_contents($path, "");
                };
                $resource = $path;
                $this->translator->setLocale($a);
                $this->translator->addLoader('json', new JsonFileLoader());
                $this->translator->addResource('json', $resource, $a, $table);
            }
        }
    }

    private function checkTable(string $table)
    {
        $pathTraductions = $this->globalConfig->getTranslatePath();
        if (!file_exists($pathTraductions . '/' . $table)) {
            mkdir($pathTraductions . '/' . $table, 0777, true);
        };
    }

    function getKeyValueFromFilter(string $filter, string $lang, string $key): string
    {
        $this->createTranslator($this->globalConfig->getDefaultLang());
        if (array_key_exists($key, $this->translator->getCatalogue($lang)->all($filter)))
            return $this->translator->getCatalogue($lang)->all($filter)[$key];
        else
            return "";

    }

    function setKeyValue(string $table, string $key, string $lang, string $value, bool $delete = false)
    {
        $inp = file_get_contents($this->globalConfig->getTranslatePath() . "/" . $table . "/" . $lang . '.json');
        $tempArray = json_decode($inp, true);
        if ($delete === true) {
            unset($tempArray[$key]);
        } else
            $tempArray[$key] = $value;
        $jsonData = json_encode($tempArray);
        file_put_contents($this->globalConfig->getTranslatePath() . "/" . $table . "/" . $lang . '.json', $jsonData);


    }

    function addKeyValue(string $table, string $key, array $values)
    {
        $this->createTranslator($this->globalConfig->getDefaultLang());

        foreach ($this->globalConfig->getAvailableLang() as $lang) {
            $this->setKeyValue($table, $key, $lang, $values[$lang]);
        }

    }

    function removeKeyValue(string $table, string $key)
    {
        $this->createTranslator($this->globalConfig->getDefaultLang());

        foreach ($this->globalConfig->getAvailableLang() as $lang) {
            $this->setKeyValue($table, $key, $lang, "", true);
        }

    }

    function getTablesName(): array
    {
        $conn = Propel::getConnection();
        $sql = "SELECT TABLE_NAME
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='" . $this->globalConfig->getDatabaseName() . "'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $arr = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $up) {
            $arr[] = $up['TABLE_NAME'];
        }

        $stmt = null;
        return $arr;
    }

    function getTranslations(string $table, int $offset, int $limit, string $filter, string $sort, string $column): array
    {
        $arr = array();

        try {
            $conn = Propel::getConnection();
            $sql = "SELECT " . $column . " FROM " . $table;

            $sql = $this->addFilters($filter, $sort, $sql);
            $sql = $sql . " LIMIT " . $limit . " OFFSET " . $offset;

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $up) {
                $arr[] = $up[$column];
            }
        } catch (\Error $e) {

        } finally {
            $stmt = null;
            return $arr;
        }
    }

    function addFilters($filter, $sort, $sql)
    {
        if ($filter !== "")
            $sql = $sql . " WHERE name LIKE '%" . $filter . "%'";
        if ($sort !== "")
            $sql = $sql . " ORDER BY name " . $sort;
        return $sql;
    }

    function getCount(string $table, string $filter, string $sort): int
    {
        $conn = Propel::getConnection();
        $sql = "SELECT COUNT(id) FROM " . $table;
        $sql = $this->addFilters($filter, $sort, $sql);

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC);


        $stmt = null;
        return $count["COUNT(id)"];
    }

    function getDefaultLang(): string
    {
        return $this->globalConfig->getDefaultLang();
    }

    function getLang(): string
    {

        return $this->headers->getHeaderValue("lang") === null ? $this->getDefaultLang() : $this->headers->getHeaderValue("lang");
    }

    function getColumnsFromTable(string $table, array $ignoreColumns = ['']): array
    {
        $conn = Propel::getConnection();
        $columns = implode(", ", $ignoreColumns);
        $columns = $columns === "" ? "' '" : $columns;
        $sql = "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = '" . $table . "'
                AND DATA_TYPE in ('text','varchar','tinytext','MEDIUMTEXT','LONGTEXT') 
                AND COLUMN_NAME NOT IN (" . $columns . ")";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $arr = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $up) {
            $arr[] = $up['COLUMN_NAME'];
        }


        $stmt = null;
        return $arr;
    }
}
