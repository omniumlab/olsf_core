<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 27/07/2017
 * Time: 11:48
 */

namespace Core\Fields\Input;


use Core\Commands\CommandInterface;
use Core\Fields\BaseField;

class BaseInputField extends BaseField implements InputFieldInterface
{
    private $defaultValue;
    private $inputKeyName;
    /**
     * Model to which it belongs if it is a field that does not exist in any table.
     * @var null|string
     */
    private $modelClassName;

    /**
     * @param string $name
     * @param string $inputKeyName
     * @param string $modelClassName
     */
    public function __construct($name, $inputKeyName = '', $modelClassName = null)
    {
        parent::__construct($name);

        if (!$inputKeyName) {
            $inputKeyName = $name;
        }

        $this->inputKeyName = $inputKeyName;
        $this->modelClassName = $modelClassName;
    }

    /**
     * @return string
     */
    public function getInputKeyName()
    {
        return $this->inputKeyName;
    }


    /**
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }



    /**
     * @return null|string
     */
    public function getModelClassName()
    {
        return $this->modelClassName;
    }


    /**
     * @param \Core\Commands\CommandInterface $request
     *
     * @return mixed
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function findValue(CommandInterface $request)
    {
        $columnName = str_replace(".", "__", $this->getInputKeyName());

        $value = $request->get($columnName, $request->get($this->getInputKeyName(), $this->defaultValue));

        if ($this->isForeignKey() && !$value)
            return null;

        $values = $this->getValues();

        if (!empty($values) && !isset($values[$value])) {
            return null;
        }

        return $value;
    }


}