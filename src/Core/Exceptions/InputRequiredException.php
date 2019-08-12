<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/06/2018
 * Time: 18:13
 */

namespace Core\Exceptions;

class InputRequiredException extends RestException
{

    /**
     * InputRequiredException constructor.
     *
     * @param string|array $inputNames
     */
    public function __construct($inputNames)
    {
        if (!is_array($inputNames)) {
            $inputNames = [$inputNames];
        }

        $message = "Some parameter are incorrect or missing: " . implode(", ", $inputNames);

        parent::__construct(422, $message);

        $this->addExtra("fields", $inputNames);
    }
}