<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/07/2017
 * Time: 20:45
 */

namespace Core\Handlers\ChangeHandlers;


use Core\Fields\Input\InputFieldInterface;
use Core\Handlers\HandlerInterface;

interface ChangeHandlerInterface extends HandlerInterface
{
    /**
     * @param InputFieldInterface|string $column
     *
     * @return void
     */
    public function addField($column);

    /**
     * @param (InputFieldInterface|string|ColumnMap)[] $column
     *
     * @return void
     */
    public function addFields($columns);

    /**
     * @return InputFieldInterface[]
     */
    public function getFields();

    public function addManualValue($field, $value);

    public function removeField($name);

    public function removeAllFields();

    public function setConnection($con);

    public function getConnection();


}