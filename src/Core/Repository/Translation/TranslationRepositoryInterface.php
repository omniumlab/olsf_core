<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 24/01/2019
 * Time: 13:39
 */

namespace Core\Repository\Translation;


use Core\Commands\RequestHeadersInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

interface TranslationRepositoryInterface
{
    function getTraduction(?string $key, string $table, bool $translateAllWords = false): ?string;

    function getOriginalKeys(string $valueTranslate, string $locale, string $table, bool $translateAllWords = false);

    function isDefaultLang(string $locale, string $default_lang): bool;

    function getLanguages(): array;

    function getAllKeyValue(): array;

    function getKeyValueFromFilter(string $filter, string $lang, string $key): string;

    function setKeyValue(string $table, string $key, string $lang, string $value);

    function addKeyValue(string $table, string $key, array $values);

    function removeKeyValue(string $table, string $key);

    function getTablesName(): array;

    function getTranslations(string $table, int $offset, int $limit, string $filter, string $sort, string $column): array;

    function getCount(string $table, string $filter, string $sort): int;

    function getDefaultLang(): string;

    function getLang(): string;
    function getColumnsFromTable(string $table, array $ignoreColumns=['']):array;
}
