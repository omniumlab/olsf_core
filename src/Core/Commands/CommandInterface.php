<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/06/2018
 * Time: 9:40
 */

namespace Core\Commands;


use Core\Fields\Input\TimeInterface;
use Core\Reflection\NameInterface;

interface CommandInterface
{
    public function getHttpVerb(): string;

    public function getResourceName(): NameInterface;

    public function getActionName(): NameInterface;

    public function setResourceName(NameInterface $name);

    public function setActionName(NameInterface $name);

    public function getAllUrlAttributes(): array;

    public function getHeaders(): array;

    public function getHeader($key, $default = null, $required = false);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setUrlAttribute($key, $value);

    /**
     * @return string El parámetro {id} de la url si existe. Si no existe, devuelve null.
     */
    public function getUrlIdParameter(): ?string;

    /**
     * @param $key string
     * @param mixed $default
     *
     * @param bool $required
     *
     * @return mixed
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     */
    public function get($key, $default = null, $required = false);

    public function has($key);

    public function all(): array;

    /**
     * Adds parameters.
     *
     * @param array $parameters An array of parameters
     */
    public function add(array $parameters = []);

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function set(string $key, $value);

    /**
     * @param string $key
     * @param string|TimeInterface $default
     * @param bool $required
     *
     * @return TimeInterface
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     */
    public function getTime(string $key, $default = '00:00', $required = false): TimeInterface;

    /**
     * @param string $key
     * @param string|int $default
     * @param bool $required
     *
     * @return int
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     */
    public function getInt(string $key, int $default = 0, $required = false): int;

    /**
     * @param string $key
     * @param string|float $default
     * @param bool $required
     *
     * @return float
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     */
    public function getFloat(string $key, float $default = 0.0, $required = false): float;

    /**
     * @param string $key
     * @param string $default
     * @param bool $required
     *
     * @return string
     * @throws \Core\Exceptions\InputRequiredException Si $required es true y el parámetro no existe
     */
    public function getString(string $key, $default = '', $required = false): string;

    /**
     * @param string $key
     * @param string|\DateTime|null $default
     * @param bool $required
     *
     * @return \DateTime
     */
    public function getDate(string $key, $default = null, bool $required = false): ?\DateTime;
}