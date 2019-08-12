<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/10/2017
 * Time: 21:58
 */

namespace Core\Entities\Change\Save\Options;


use Core\Entities\Options\BaseColumn;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Fields\Input\InputFieldInterface;
use Core\Text\TextHandlerInterface;


class SaveColumn extends BaseColumn
{

    /*
     * "required" bool
     * "linkedToColumn" BaseLinkedToColumn
     * "dependencyColumns" string[]
     */
    public function __construct(InputFieldInterface $column,
                                ColumnTypeFormatterInterface $columnTypeFormatter,
                                TextHandlerInterface $textHandler)
    {
        parent::__construct($column, $columnTypeFormatter, $textHandler);
        $this->setRequired($column->isRequired());
    }

    /**
     * @return bool
     */
    public function getRequired()
    {
        return $this->getVariable("required");
    }

    /**
     * @param bool $required
     */
    public function setRequired($required)
    {
        $this->setVariable("required", $required);
    }

    /**
     * @param BaseLinkedToColumn $linkedToColumn
     */
    public function setLinkedToColumn(BaseLinkedToColumn $linkedToColumn){
        $this->setVariable("linkedToColumn", $linkedToColumn);
    }

    public function setDependencyColumns(array $columnNames)
    {
        $this->setVariable("dependencyColumns", $columnNames);
    }

    /**
     * Hasta que los campos que se especifica usando este método no estén rellenos no se activará esta columna.
     * Además los dependencyColumns añadiran su valor al filtro de la llamada de los campos autocomplete.
     * @param string $columnName
     * @return $this
     */
    public function addDependencyColumn(string $columnName)
    {
        if ($this->getVariable("dependencyColumns") === null)
            $this->setDependencyColumns([$columnName]);
        else
            $this->addValueToVariableArray("dependencyColumns", $columnName);

        return $this;
    }
}
