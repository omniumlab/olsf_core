<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 20/10/17
 * Time: 10:57
 */

namespace Core\Entities\Options;


use Core\Entities\EntityInterface;
use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;


class Action implements ActionInterface, ValueInterface
{
    /**
     * @var ListValueInterface Class variables
     * "entity_name" string
     * "visualName" string
     * "icon" string
     * "onlyIcon" bool
     * "dynamicParams" string[]
     * "dynamicParamsCorrespondences" string[]
     * "askMessage" string
     * "style" string
     * "visibilityColumn": string Nombre del campo boolean que decidirá si esta action es visible o no.
     */
    private $variables;

    /**
     * @var \Core\Entities\EntityInterface
     */
    private $entity;


    public function __construct(EntityInterface $entity)
    {
        $this->variables = new BaseListValue();

        $this->entity = $entity;
        $this->setVisualName($entity->getVisualName());
        $this->setIcon("");
        $this->setOnlyIcon(true);
        $this->setAskMessage("");
    }

    /**
     * @return string
     */
    public function getVisualName()
    {
        return $this->variables->getValue("visualName");
    }

    /**
     * @param string $visualName
     *
     * @return $this Current instance for fluid interface
     */
    public function setVisualName($visualName)
    {
        $this->variables->setValue($visualName, "visualName");

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->variables->getValue("icon");
    }

    /**
     * @param string $icon
     *
     * @return $this Current instance for fluid interface
     */
    public function setIcon($icon)
    {
        $this->variables->setValue($icon, "icon");

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnlyIcon()
    {
        return $this->variables->getValue("onlyIcon");
    }

    /**
     * @param bool $onlyIcon
     *
     * @return $this Current instance for fluid interface
     */
    public function setOnlyIcon($onlyIcon)
    {
        $this->variables->setValue($onlyIcon, "onlyIcon");

        return $this;
    }

    /**
     * @return string
     */
    public function getAskMessage()
    {
        return $this->variables->getValue("askMessage");
    }

    /**
     * @param string $askMessage
     *
     * @return $this Current instance for fluid interface
     */
    public function setAskMessage($askMessage)
    {
        $this->variables->setValue($askMessage, "askMessage");

        return $this;
    }

    /**
     * @param $style string
     * @return $this Current instance for fluid interface
     */
    public function setStyle($style){
        $this->variables->setValue($style, "style");

        return $this;
    }

    public function getDynamicParams():array {
        return $this->variables->getValue("dynamicParams");
    }

    /**
     * Specify which parameters will be passed to the entity of this action.
     * @param array $params
     * @return $this Current instance for fluid interface
     */
    public function setDynamicParams(array $params)
    {
        $this->variables->setValue($params, "dynamicParams");

        return $this;
    }

    /**
     * @param string[] $paramsCorrespondences
     * @return $this
     */
    public function setDynamicParamsCorrespondences(array $paramsCorrespondences){
        assert(count($this->getDynamicParams()) === count($paramsCorrespondences),
            "dynamicParamsCorrespondences must have the same number of elements as dynamicParams.");
        $this->variables->setValue($paramsCorrespondences, "dynamicParamsCorrespondences");
        return $this;
    }

    public function setVisibilityColumn(string $fieldName)
    {
        $this->variables->setValue($fieldName, "visibilityColumn");
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        $this->variables->setValue($this->entity->getName(), "entity_name");

        return $this->variables->getValues();
    }
}
