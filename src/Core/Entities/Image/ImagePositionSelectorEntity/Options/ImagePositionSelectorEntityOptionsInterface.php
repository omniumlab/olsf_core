<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/02/2019
 * Time: 15:03
 */

namespace Core\Entities\Image\ImagePositionSelectorEntity\Options;


use Core\Entities\Options\EntityOptionsInterface;
use Core\Text\TextHandlerInterface;

interface ImagePositionSelectorEntityOptionsInterface extends EntityOptionsInterface
{
    /**
     * @param string $entity
     * @return $this
     */
    function setEntityGetInformation(string $entity);

    /**
     * @param string $entity
     * @return $this
     */
    function setEntitySetPoint(string $entity);

    /**
     * @param string $entity
     * @return $this
     */
    function setEntityFilter(string $entity);


    /**
     * @param string $entity
     * @return $this
     */
    function setEntityDelete(string $entity);

    /**
     * @param string $entity
     * @return $this
     */
    function setEntityDeleteAll(string $entity);

    /**
     * @param ImagePositionFieldInterface[]
     * @return $this
     */
    function setFields(array $fields);

    /**
     * @param TextHandlerInterface $textHandler
     * @return ImagePositionFieldInterface[]
     */
    function createSystemFields(TextHandlerInterface $textHandler): array;
}