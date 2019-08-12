<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/07/2017
 * Time: 17:57
 */

namespace Core\Fields\Input;


use Core\Commands\CommandInterface;
use Core\Fields\FieldInterface;

interface InputFieldInterface extends FieldInterface
{

    /**
     * @return string
     */
    public function getInputKeyName();


    /**
     * @param \Core\Commands\CommandInterface $request
     *
     * @return mixed
     */
    public function findValue(CommandInterface $request);
}