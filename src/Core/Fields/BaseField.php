<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 26/10/17
 * Time: 15:24
 */

namespace Core\Fields;


use phpDocumentor\Reflection\Types\This;

class BaseField implements FieldInterface
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $primaryKey = false;

    private $type;
    private $required = false;
    private $values = [];
    private $foreignKey = false;
    private $alias;

    /**
     * @param string $name
     */
    public function __construct($name, $alias = null)
    {
        $this->name = $name;
        
        if ($alias === null)
            $alias = $name;

        $this->alias = $alias;
    }


    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     * @return $this
     */
    public function setAlias(?string $alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return string Unique name of the field
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isPrimaryKey()
    {
        return $this->primaryKey;
    }



    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    public function addValue($key, $value)
    {

        $this->values[$key] = $value;
    }

    /**
     * @param bool $primaryKey
     * @return $this
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * @param mixed $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param mixed $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @param mixed $values
     *
     * @return $this
     */
    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @return bool
     */
    public function isForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @param bool $foreignKey
     * @return $this
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;
        return $this;
    }


}
