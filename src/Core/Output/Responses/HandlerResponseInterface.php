<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 19/10/17
 * Time: 10:37
 */

namespace Core\Output\Responses;

interface HandlerResponseInterface
{

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return integer
     */
    public function getStatusCode();

    /**
     * @param int $statusCode
     *
     * @return void
     */
    public function setStatusCode(int $statusCode);

    /**
     * @return integer
     */
    public function getType();

    /**
     * @return mixed
     */
    public function getData();

    public function setData(array $data);

    /**
     * @param string $name
     * @param array|string $value
     *
     * @param bool $replace
     *
     * @return mixed
     */
    public function setHeader(string $name, $value = '', bool $replace = true);

    public function getHeaders(): array;

    public function toArray(): array;

    /**
     * Añade un valor a los datos de esta respuesta.
     *
     * @param string|array $namePath Nombre de la clave donde se va a almacenar el valor. Puede ser un array si se
     *     necesita seguir un camino hasta la posición final. Si es un string, el valor irá en el raíz de "data"
     * @param mixed $value Valor que se desea almacenar. Si se especifica un array, y la posición final ya tiene un
     *     array, se concatenará al ya existente, reemplazando los datos que existan por los nuevos. En cualquier otro
     *     caso, el valor existente se sobrescribirá.
     *
     */
    public function setDataValue($namePath, $value);

    /**
     * Añade un valor como nuevo valor de un array de dentro de los datos de esta respuesta.
     *
     * @param string|array $namePath Nombre de la clave donde se va a almacenar el valor. Puede ser un array si se
     *     necesita seguir un camino hasta la posición final. Si es un string, el valor irá en el raíz de "data". Si la
     *     ruta hasta esta posición no es un array se creará uno en blanco en dicha posición sobreescribiendo el vaor
     *     existente.
     * @param mixed $value Valor que se desea almacenar. Si se especifica un array, y la posición final ya tiene un
     *     array, se concatenará al ya existente. En cualquier otro caso, el valor existente se sobrescribirá.
     *
     */
    public function addDataArrayValue($namePath, $value): void;
}
