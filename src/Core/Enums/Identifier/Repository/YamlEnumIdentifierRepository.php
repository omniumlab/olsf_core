<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/08/2018
 * Time: 9:56
 */

namespace Core\Enums\Identifier\Repository;


use Core\Text\TextHandlerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlEnumIdentifierRepository
 *
 * @package Core\Enums\Identifier\Repository
 *
 * @uses Yaml
 */
class YamlEnumIdentifierRepository extends AbstractEnumIdRepository
{
    /**
     * @var string
     */
    private $fileName;


    /**
     * EnumIdentifierRepository constructor.
     *
     * @param string $enumName Nombre del enum. Se usará para coger el archivo dentro de
     *     /app/config/app/enums/<enumName>.yml
     * @param TextHandlerInterface|null $textHandler
     */
    public function __construct(string $enumName, ?TextHandlerInterface $textHandler = null)
    {
        parent::__construct($enumName, $textHandler);

        $this->fileName = __DIR__ . "/../../../../../app/config/app/enums/" . $enumName . ".yml";
    }

    /**
     * @return array Ids del enum donde la clave es el nombre único en texto y el valor es el id numérico. Los
     *     ids dentro de un enum son únicos. Si un id es repetido, se lanzará una excepción.
     */
    protected function getEnumIds(): array
    {
        return Yaml::parseFile($this->fileName);
    }
}
