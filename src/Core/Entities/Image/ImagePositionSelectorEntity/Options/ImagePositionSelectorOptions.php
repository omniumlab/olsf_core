<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/02/2019
 * Time: 15:03
 */

namespace Core\Entities\Image\ImagePositionSelectorEntity\Options;


use Core\Entities\Options\EntityOptions;
use phpDocumentor\Reflection\Types\This;
use Core\Text\TextHandlerInterface;

class ImagePositionSelectorOptions extends EntityOptions implements ImagePositionSelectorEntityOptionsInterface
{
    /*
     *  entity_get_information: string
     *  entity_set_point: string
     *  entity_filter: string|null
     *  fields: ImagePositionFieldInterface[]
     */

    /**
     * @param string $entity
     * @return $this
     */
    function setEntityGetInformation(string $entity)
    {
        $this->setVariable("entity_get_information", $entity);
        return $this;
    }

    /**
     * @param string $entity
     * @return $this
     */
    function setEntitySetPoint(string $entity)
    {
        $this->setVariable("entity_set_point", $entity);
        return $this;
    }

    /**
     * @param string $entity
     * @return $this
     */
    function setEntityFilter(string $entity)
    {
        $this->setVariable("entity_filter", $entity);
        return $this;
    }

    /**
     * @param string $entity
     * @return $this
     */
    function setEntityDeleteAll(string $entity)
    {
        $this->setVariable("entity_delete_all", $entity);
        return $this;
    }


    /**
     * @param string $entity
     * @return $this
     */
    function setEntityDelete(string $entity)
    {
        $this->setVariable("entity_delete", $entity);
        return $this;
    }

    /**
     * @param ImagePositionFieldInterface[] $fields
     * @return $this
     */
    function setFields(array $fields)
    {
        $this->setVariable("fields", $fields);
        return $this;
    }

    /**
     * @param TextHandlerInterface $textHandler
     * @return ImagePositionFieldInterface[]
     */
    function createSystemFields(TextHandlerInterface $textHandler): array
    {
        $width = (new ImagePositionField())
            ->setName("_width")
            ->setVisualName($textHandler->get("width"))
            ->setType(ImagePositionFieldInterface::TYPE_NUMBER);

        $height = (new ImagePositionField())
            ->setName("_height")
            ->setVisualName($textHandler->get("height"))
            ->setType(ImagePositionFieldInterface::TYPE_NUMBER);

        $color = (new ImagePositionField())
            ->setName("_color")
            ->setVisualName($textHandler->get("color"))
            ->setType(ImagePositionFieldInterface::TYPE_COLOR);

        return [$width, $height, $color];
    }
}