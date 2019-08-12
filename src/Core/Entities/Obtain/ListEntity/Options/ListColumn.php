<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 20/10/17
 * Time: 11:01
 */

namespace Core\Entities\Obtain\ListEntity\Options;

use Core\Entities\Options\BaseColumn;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Fields\Output\OutputFieldInterface;
use Core\Text\TextHandlerInterface;

class ListColumn extends BaseColumn
{
    const POSITION_TOP = "TOP";
    const POSITION_TABLE_HEAD = "TABLE_HEAD";
    const POSITION_HIDDEN = "HIDDEN";

    /*
     * Class Variables
     * "sortable" bool
     * "link" BaseLink
     * "useFilterOf" string
     * "valueColors" array
     * "editEntityName string
     * "filterPosition" string
     */

    public function __construct(OutputFieldInterface $outputField,
                                ColumnTypeFormatterInterface $columnTypeFormatter,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct($outputField, $columnTypeFormatter, $textHandler);
        $this->setSortable(true);

    }

    /**
     * @return bool
     */
    public function isSortable()
    {
        return $this->getVariable("sortable");
    }

    /**
     * @param bool $sortable
     */
    public function setSortable($sortable)
    {
        $this->setVariable("sortable", $sortable);
    }

    public function setLink(BaseLink $link)
    {
        $this->setVariable("link", $link);
    }

    /**
     * @param $field string
     */
    public function setUseFilterOf($field)
    {
        $this->setVariable("useFilterOf", $field);
    }

    /**
     * @param $value mixed
     * @param $color string
     */
    public function addValueColor($value, $color)
    {
        if (!in_array("valueColors", array_keys($this->getValues()))) {
            $this->setVariable("valueColors", []);
        }

        $this->addValueToVariableArray("valueColors", $color, $value);
    }

    /**
     * @param $valueSet array
     * @param $enumValue
     * @param $color string
     */
    public function addValueColorByEnum($valueSet, $enumValue, $color)
    {
        $key = array_search($enumValue, $valueSet);

        $this->addValueColor($key, $color);
    }

    public function setEditEntityName(string $entityName)
    {
        $this->setVariable("editEntityName", $entityName);
    }

    public function setOnEditSendAllFields(bool $sendAllFields)
    {
        $this->setVariable("onEditSendAllFields", $sendAllFields);
    }

    public function setFilterPosition(string $position)
    {
        $this->setVariable("filterPosition", $position);
        return $this;
    }

}
