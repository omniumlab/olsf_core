<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/08/2018
 * Time: 20:34
 */

namespace Core\Enums\Identifier;


use Core\Enums\Identifier\Repository\YamlEnumIdentifierRepository;
use Core\Reflection\Name;

class YamlEnumValueIdentifier extends NamedEnumValueIdentifier
{

    /**
     * ClassEnumKeyName constructor.
     *
     * @param object|string $target Class name, object or key name in camel case or snake case
     * @param string $enumName
     * @param string $suffix
     */
    public function __construct($target, string $enumName, string $suffix = '')
    {
        parent::__construct(new Name($target, $suffix), new YamlEnumIdentifierRepository($enumName));
    }
}