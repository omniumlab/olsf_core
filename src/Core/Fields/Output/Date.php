<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2017
 * Time: 19:54
 */

namespace Core\Fields\Output;


class Date extends Timestamp
{
    public function __construct($name, $alias = null)
    {
        parent::__construct($name, $alias);

        $this->setFormat("d/m/Y");
    }

}