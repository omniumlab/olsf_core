<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/10/2017
 * Time: 22:08
 */

namespace Core\Entities\Options;


use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Fields\FieldInterface;
use Core\Fields\Output\OutputFieldInterface;
use Core\Handlers\HandlerInterface;
use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;
use Core\Text\TextHandlerInterface;

abstract class BaseColumn implements ValueInterface, ColumnInterface
{

    /**
     * @var ListValueInterface $variables Class variables
     * "name" string
     * "visualName" string
     * "primary" bool
     * "type" string
     * "foreignListEntityName" string
     * "foreignListEntityParams" array
     * "visible" bool
     * "placeholder" string
     * "default"
     */
    private $variables;
    /**
     * @var OutputFieldInterface
     */
    private $column;

    /** @var TextHandlerInterface */
    private $textHandler;

    /**
     * SaveColumn constructor.
     *
     * @param FieldInterface $column
     * @param ColumnTypeFormatterInterface $columnTypeFormatter
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(FieldInterface $column,
                                ColumnTypeFormatterInterface $columnTypeFormatter,
                                TextHandlerInterface $textHandler)
    {
        $this->variables = new BaseListValue();
        $this->textHandler = $textHandler;

        $this->column = $column;
        $this->setName($column->getAlias());
        $this->setVisualName($this->convertNameToVisualName());
        $this->setPrimary($column->isPrimaryKey());

        if ($column->isForeignKey()) {
            $this->setType(HandlerInterface::TYPE_AUTOCOMPLETE);
        } else {
            $this->setType($columnTypeFormatter->getBddTypeFormatted($column->getType()));
        }

        $this->setValuesInList($column->getValues());
    }


    /**
     * @return string
     */
    public function convertNameToVisualName()
    {
        $name = $this->getName();
        $translatedName = $this->textHandler->get($name);

        if ($translatedName === $name){
            $name = strstr($name, ".");
            $name = substr($name, 1);
            $name = str_replace("_", " ", $name);

            $name = ucwords($name);
        }else{
            $name = $translatedName;
        }

        return $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->variables->getValue("name");
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->variables->setValue($name, "name");
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
     */
    public function setVisualName($visualName)
    {
        $this->variables->setValue($visualName, "visualName");
    }

    /**
     * @param $tooltip
     */
    public function setToolTip($tooltip)
    {
        $this->variables->setValue($tooltip, "toolTip");
    }
    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->variables->getValue("primary");
    }

    /**
     * @param bool $primary
     */
    public function setPrimary($primary)
    {
        $this->variables->setValue($primary, "primary");
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->variables->getValue("type");
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->variables->setValue($type, "type");
    }

    public function setVisible($visible)
    {
        $this->setVariable("visible",$visible);
    }

    /**
     * @return BaseValue[]
     */
    public function getValuesInList()
    {
        return $this->variables->getValue("values");
    }

    /**
     * @param $values
     */
    public function setValuesInList($values)
    {
        $baseValues = [];

        foreach ($values as $key => $value) {
            $baseValues[] = new BaseValue($key, $value);
        }

        $this->variables->setValue($baseValues, "values");
    }


    /**
     * @param $entityName string
     */
    public function setForeignListEntityName($entityName)
    {
        $this->setVariable("foreignListEntityName", $entityName);
    }


    public function setForeignListEntityParams(array $params)
    {
        $this->setVariable("foreignListEntityParams", $params);
    }


    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->getVariable("placeholder");
    }

    /**
     * @param string|null $placeholder
     * @return $this
     */
    public function setPlaceholder(?string $placeholder)
    {
        $this->setVariable("placeholder", $placeholder);
        return $this;
    }

    public function setDefault($default)
    {
        $this->setVariable("default", $default);
        return $this;
    }


    public function getVariable($variableName)
    {
        return $this->variables->getValue($variableName);
    }

    public function setVariable($variableName, $value)
    {

        $this->variables->setValue($value, $variableName);
    }

    public function addValueToVariableArray($arrayName, $value, $key = null){
        $this->variables->addItemToArray($arrayName, $value, $key);
    }

    public function getValues()
    {
        return $this->variables->getValues();
    }
}
