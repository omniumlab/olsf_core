<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/08/2018
 * Time: 16:05
 */

namespace Core\Enums\Identifier;


class EnumValueIdentifier implements EnumValueIdentifierInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * EnumValueIdentifier constructor.
     *
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;

        if ($name === null) {
            $name = strval($id);
        }

        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}