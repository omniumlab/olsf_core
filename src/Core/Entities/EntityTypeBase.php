<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 29/06/2018
 * Time: 22:21
 */

namespace Core\Entities;


class EntityTypeBase implements EntityTypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * EntityTypeBase constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    function getName(): string
    {
        return $this->name;
    }
}