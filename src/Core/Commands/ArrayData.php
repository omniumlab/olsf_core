<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 16/07/2018
 * Time: 21:54
 */

namespace Core\Commands;


use Core\Exceptions\InputFormatException;
use Core\Exceptions\InputRequiredException;
use Core\Fields\Input\Time;
use Core\Fields\Input\TimeInterface;

abstract class ArrayData
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * AbstractArrayData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $key string
     * @param mixed $default
     *
     * @param bool $required
     *
     * @return mixed
     * @throws InputRequiredException Si $required es true y el parámetro no existe
     */
    public function get($key, $default = null, $required = false)
    {
        if (!$this->has($key)) {
            if ($required) {
                throw new InputRequiredException($key);
            }

            return $default;
        }

        return $this->data[$key];
    }

    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function all(): array
    {
        return $this->data;
    }

    /**
     * Adds parameters.
     *
     * @param array $parameters An array of parameters
     */
    public function add(array $parameters = [])
    {
        array_replace($this->data, $parameters);
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    public function setAll(array $data)
    {
        $this->data = $data;
    }

    public function remove(string $key)
    {
        unset($this->data[$key]);
    }

    /**
     * @param string $key
     * @param TimeInterface|string $default
     * @param bool $required
     *
     * @return \Core\Fields\Input\TimeInterface
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     * @throws \Core\Exceptions\InputFormatException
     */
    public function getTime(string $key, $default = '00:00', $required = false): TimeInterface
    {
        $regex = "#^([0-9]+):([0-5][0-9])$#";

        $this->getWithFormat($key, $regex, $required, $matches);

        if (!is_array($matches) || count($matches) !== 3) {
            if ($default instanceof TimeInterface) {
                return $default;
            }

            $this->set($key, $default);

            $this->getWithFormat($key, $regex, $required, $matches);
        }

        return new Time(intval($matches[1]), intval($matches[2]));
    }

    /**
     * @param string $key
     * @param int $default
     * @param bool $required
     *
     * @return int
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     * @throws \Core\Exceptions\InputFormatException Si el formato es incorrecto
     */
    public function getInt(string $key, int $default = 0, $required = false): int
    {
        $value = $this->getWithFormat($key, "#^([+\-]?\d+)$#", $required);

        if ($value === null) {
            $value = $default;
        }

        return intval($value);
    }

    /**
     * @param string $key
     * @param float $default
     * @param bool $required
     *
     * @return float
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     * @throws \Core\Exceptions\InputFormatException Si el formato es incorrecto
     */
    public function getFloat(string $key, float $default = 0.0, $required = false): float
    {
        $value = $this->getWithFormat($key, "#^([+\-]?\d+(?:\.\d+)?)$#", $required);

        if ($value === null) {
            $value = $default;
        }

        return floatval($value);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @param bool $required
     *
     * @return string
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     */
    public function getString(string $key, $default = '', $required = false): string
    {
        return strval($this->get($key, $default, $required));
    }

    /**
     * @param string $key
     * @param string $regex
     * @param bool $required
     *
     * @param string[] $matches
     *
     * @return null|string El valor una vez que se ha comprobado el formato. <code>null</code> si el valor no viene y
     *     $required es false
     * @throws \Core\Exceptions\InputFormatException Si el formato del valor recibido es incorrecto
     * @throws \Core\Exceptions\InputRequiredException Si el valor no viene y $required es true
     */
    public function getWithFormat(string $key, string $regex, $required = false, &$matches = null)
    {
        try {
            $value = $this->getString($key, '', true);

            if (!preg_match($regex, $value, $matches)) {
                throw new InputFormatException("Incorrect value '" . $value . "' for parameter '" . $key . "'");
            }

            return $value;
        } catch (InputRequiredException $e) {
            if ($required) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * @param string $key
     * @param bool $default
     * @param bool $required
     *
     * @return bool
     * @throws \Core\Exceptions\InputRequiredException
     * @throws \Core\Exceptions\InputFormatException
     */
    public function getBoolean(string $key, bool $default = false, $required = false): bool
    {
        try {
            $value = $this->getString($key, '', true);
        } catch (InputRequiredException $e) {
            if ($required) {
                throw $e;
            }

            return $default;
        }

        $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($boolValue === null) {
            throw new InputFormatException("Incorrect boolean value: '" . $value . "'. Accepted values are: '1', 'true', " .
                                           "'on' or 'yes' for true and '0', 'false', 'off' and 'no' for false");
        }

        return $boolValue;
    }

    /**
     * @param string $key
     * @param string|\DateTime|null $default
     * @param bool $required
     *
     * @return \DateTime
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function getDate(string $key, $default = null, bool $required = false): ?\DateTime
    {
        try {
            $value = $this->getString($key, '', true);
        } catch (InputRequiredException $e) {
            if ($required) {
                throw $e;
            }

            if ($default instanceof \DateTime || $default === null) {
                return $default;
            }

            $value = $default;
        }

        return new \DateTime($value);
    }
}