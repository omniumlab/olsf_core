<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 26/10/17
 * Time: 15:22
 */

namespace Core\Fields;


interface FieldInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function isPrimaryKey();

    /**
     * @param $primaryKey bool
     */
    public function setPrimaryKey($primaryKey);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return bool
     */
    public function isRequired();

    /**
     * @return mixed
     */
    public function getValues();

    /**
     * @param $values array
     */
    public function setValues($values);

    /**
     * @return bool
     */
    public function isForeignKey();

    /**
     * @param bool $foreignKey
     *
     * @return $this
     */
    public function setForeignKey($foreignKey);


    public function getAlias();

    /**
     * @param string|null $alias
     * @return $this
     */
    public function setAlias(?string $alias);
}
