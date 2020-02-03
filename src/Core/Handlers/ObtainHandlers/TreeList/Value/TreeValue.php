<?php


namespace Core\Handlers\ObtainHandlers\TreeList\Value;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class TreeValue implements ValueInterface
{
    /**
     * @var ListValueInterface Class variables
     * "id" int
     * "value" string
     * "arguments" ?[string => string]
     * "selectable" ?bool
     * "spreadable" ?bool
     * "expanded" ?bool
     * "children" TreeValue[]
     */
    private $variables;

    public function __construct()
    {
        $this->variables = new BaseListValue();
        $this->setChildren([]);
    }

    public function setId(int $id): TreeValue
    {
        $this->variables->setValue($id, "id");
        return $this;
    }

    public function setValue(string $value): TreeValue
    {
        $this->variables->setValue($value, "value");
        return $this;
    }

    public function setArguments(?array $arguments): TreeValue
    {
        if ($arguments === null)
            return $this;

        $this->variables->setValue($arguments, "arguments");
        return $this;
    }

    public function setSelectable(?bool $selectable): TreeValue
    {
        if ($selectable === null)
            return $this;

        $this->variables->setValue($selectable, "selectable");
        return $this;
    }

    public function setSpreadable(?bool $spreadable): TreeValue
    {
        if ($spreadable === null)
            return $this;

        $this->variables->setValue($spreadable, "spreadable");
        return $this;
    }

    public function setExpanded(?bool $expanded): TreeValue
    {
        if ($expanded === null)
            return $this;

        $this->variables->setValue($expanded, "expanded");
        return $this;
    }

    /**
     * @param TreeValue[] $children
     * @return TreeValue
     */
    public function setChildren(array $children): TreeValue
    {
        $this->variables->setValue($children, "children");
        return $this;
    }

    public function addChild(TreeValue $child): TreeValue
    {
        $this->variables->getValue("children")[] = $child;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}
