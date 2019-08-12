<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 10/04/2019
 * Time: 12:29
 */

namespace Core\Output\Responses;


class RawResponse implements HandlerResponseInterface
{

    /** @var array|null */
    private $data;

    private $headers = [];

    private $statusCode;

    public function __construct(int $statusCode, array $data = [])
    {
        $this->setStatusCode($statusCode);
        $this->setData($data);
    }

    /**
     * @return string
     */
    public function getMessage()
    {

    }

    /**
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return void
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return integer
     */
    public function getType()
    {

    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $name
     * @param array|string $value
     * @param bool $replace
     *
     * @return mixed|void
     */
    public function setHeader(string $name, $value = '', bool $replace = true)
    {
        if (!array_key_exists($name, $this->headers) || $replace) {
            $this->headers[$name] = $value;
        } else {
            $this->headers[$name] = array_merge($this->headers[$name], $value);
        }

    }


    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function toArray(): array
    {
        return $this->data;
    }

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
    public function setDataValue($namePath, $value)
    {

    }

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
    public function addDataArrayValue($namePath, $value): void
    {

    }
}
