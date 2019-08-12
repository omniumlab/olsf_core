<?php


namespace Core\SpreadSheet;


class ImportedExcel
{
    /** String[] */
    private $columns;

    /** array[][] */
    private $values;

    /**
     */
    public function __construct()
    {
        $this->columns = array();
        $this->values = array();
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @param mixed $values
     */
    public function setValues($values): void
    {
        $this->values = $values;
    }




}