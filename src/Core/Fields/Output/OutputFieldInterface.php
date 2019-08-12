<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/07/2017
 * Time: 20:30
 */

namespace Core\Fields\Output;


use Core\Fields\FieldInterface;

interface OutputFieldInterface extends FieldInterface
{

    /**
     * @param mixed $value
     *
     * @return mixed BaseValue of this column
     */
    public function formatValue($value);


    /**
     * @return string
     */
    public function getSelectClause();

}