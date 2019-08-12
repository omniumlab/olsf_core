<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 19/10/17
 * Time: 10:33
 */

namespace Core\Output\Responses;


abstract class HandlerResponseBase implements HandlerResponseInterface
{
    const TYPE_SUCCESS = 0;
    const TYPE_ERROR = 1;
    const TYPE_WARNING = 2;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data;

    private $type;

    /**
     * @var integer
     */
    private $jsonOptions;
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $headers = [];

    public function __construct($statusCode, $message, array $data, $type, $jsonOptions = 0)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
        $this->type = $type;
        $this->jsonOptions = $jsonOptions;
    }

    /**
     * @return string|[]
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed[]
     */
    public function getData()
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
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

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function toArray(): array
    {
        return [
            "status"  => $this->getStatusCode(),
            "type"    => $this->getType(),
            "message" => $this->getMessage(),
            "data"    => $this->getData(),
        ];

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
        $finalPosition = &$this->getArrayPosition($namePath);

        if (is_array($finalPosition) && is_array($value)) {
            $finalPosition = array_replace($finalPosition, $value);
        } else {
            $finalPosition = $value;
        }
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
        $finalPosition = &$this->getArrayPosition($namePath);

        if (!is_array($finalPosition)) {
            $finalPosition = [];
        }

        $finalPosition[] = $value;
    }

    private function &getArrayPosition($namePath)
    {
        if (!is_array($namePath)) {
            $namePath = [$namePath];
        }

        $finalPosition = &$this->data;

        foreach ($namePath as $name) {
            if (!is_array($finalPosition)) {
                $finalPosition = [];
            }

            if (!array_key_exists($name, $finalPosition)) {
                $finalPosition[$name] = "";
            }

            $finalPosition = &$finalPosition[$name];
        }

        return $finalPosition;
    }
}
