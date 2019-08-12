<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 05/03/2019
 * Time: 14:48
 */

namespace Core\Entities\Image\ImagePositionSelectorEntity\Options;

use Core\ListValue\BaseListValue;

class ImagePositionField implements ImagePositionFieldInterface
{

    /**
     * @var BaseListValue
     * name: string
     * visualName: string
     * type: string
     */
    private $values;

    public function __construct()
    {
        $this->values = new BaseListValue();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->values->getValue("name");
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->values->setValue($name, "name");
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVisualName()
    {
        return $this->values->getValue("visualName");
    }

    /**
     * @param mixed $visualName
     * @return $this
     */
    public function setVisualName($visualName)
    {
        $this->values->setValue($visualName, "visualName");
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->values->getValue("type");
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->values->setValue($type, "type");
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values->getValues();
    }
}