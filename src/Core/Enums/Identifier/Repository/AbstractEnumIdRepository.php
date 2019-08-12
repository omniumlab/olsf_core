<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 08/08/2018
 * Time: 10:24
 */

namespace Core\Enums\Identifier\Repository;


use Core\Text\TextHandlerInterface;

abstract class AbstractEnumIdRepository implements EnumIdRepositoryInterface
{

    /**
     * @var array Ids de todos los enum. La clave es el nombre del enum y el valor es un array cuyas clave son el
     *     nombre único en texto y el valor es el id numérico. Los ids dentro de un enum son únicos
     */
    private static $cache = [];

    /**
     * @var string
     */
    private $enumName;

    /** @var TextHandlerInterface|null */
    private $textHandler;

    /**
     * AbstractEnumIdRepository constructor.
     *
     * @param string $enumName
     * @param TextHandlerInterface|null $textHandler
     */
    public function __construct(string $enumName, ?TextHandlerInterface $textHandler = null)
    {
        $this->enumName = $enumName;
        $this->textHandler = $textHandler;
    }

    /**
     * @return array Ids del enum donde la clave es el nombre único en texto y el valor es el id numérico. Los
     *     ids dentro de un enum son únicos. Si un id es repetido, se lanzará una excepción.
     */
    abstract protected function getEnumIds(): array;

    public function getId(string $key): ?int
    {
        $this->all();
        return array_key_exists($key, self::$cache[$this->enumName]) ? self::$cache[$this->enumName][$key] : null;
    }

    public function all(): array
    {
        if (!array_key_exists($this->enumName, self::$cache)) {
            self::$cache[$this->enumName] = [];
            foreach ($this->getEnumIds() as $key => $id) {
                if (in_array($id, self::$cache[$this->enumName])) {
                    throw new \InvalidArgumentException("Enum " . get_class($this) . " repeats id " . $id);
                }

                self::$cache[$this->enumName][$key] = $id;
            }
        }

        $response = [];
        if ($this->textHandler !== null)
            foreach (self::$cache[$this->enumName] as $key => $value){
                $index = $this->textHandler->get($key);
                $response[$index] = $value;
            }

        return empty($response) ? self::$cache[$this->enumName] : $response;
    }
}
