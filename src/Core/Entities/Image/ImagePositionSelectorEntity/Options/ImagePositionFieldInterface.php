<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 05/03/2019
 * Time: 14:48
 */

namespace Core\Entities\Image\ImagePositionSelectorEntity\Options;


use Core\ListValue\ValueInterface;

interface ImagePositionFieldInterface extends ValueInterface
{
    const TYPE_NUMBER = "number";
    const TYPE_STRING = "text";
    const TYPE_COLOR = "color";

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * @return mixed
     */
    public function getVisualName();

    /**
     * @param mixed $visualName
     * @return $this
     */
    public function setVisualName($visualName);

    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type);
}