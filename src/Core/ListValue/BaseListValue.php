<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 25/10/17
 * Time: 16:35
 */

namespace Core\ListValue;


class BaseListValue implements ListValueInterface
{
    /**
     * @var array
     */
    private $variables;

    /**
     * BaseListValue constructor.
     *
     * @param array $variables
     */
    public function __construct(array $variables = [])
    {
        $this->variables = $variables;
    }


    /**
     * @return array
     */
    public function getValues()
    {
        return $this->getArrayFromObject($this->variables);
    }

    /**
     * @param             $value mixed
     * @param null|string $key
     */
    public function setValue($value, $key = null)
    {
        if ($key !== null) {
            $this->variables[$key] = $value;
        } else {
            $this->variables[] = $value;
        }
    }


    /**
     * @param $key int|string
     *
     * @return mixed
     */
    public function getValue($key)
    {
        return isset($this->variables[$key]) ? $this->variables[$key] : null;
    }

    public function addItemToArray($arrayName, $value, $key = null, $index = null)
    {
        if ($key === null) {
            if ($index !== null) {
                $this->variables[$arrayName][$index] = $value;
                ksort($this->variables[$arrayName]);
            } else
                $this->variables[$arrayName][] = $value;
        } else {
            $this->variables[$arrayName][$key] = $value;
        }
    }


    private
    function getArrayFromObject($object)
    {
        $array = [];

        foreach ($object as $key => $variable) {

            if (is_array($variable)) {
                $array[$key] = self::getArrayFromObject($variable);

            } else if ($variable instanceof ValueInterface) {
                $array[$key] = $variable->getValues();
            } else {
                $array[$key] = $variable;
            }
        }
        return $array;
    }
}
