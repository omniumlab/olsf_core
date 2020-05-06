<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 16/04/2019
 * Time: 15:59
 */

namespace Core\Fields\Input;


use Core\Commands\CommandInterface;
use Core\Repository\File\FileRepositoryInterface;

class Canvas extends BaseInputField
{

    public function __construct(string $name,$inputKeyName = '', $modelClassName = null)
    {
        parent::__construct($name, $inputKeyName,$modelClassName);
    }


    public function getType()
    {
        return "canvas";
    }
}
