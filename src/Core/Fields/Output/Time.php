<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 21/07/2017
 * Time: 9:21
 */

namespace Core\Fields\Output;


class Time extends Timestamp
{
    public function __construct($name, $alias = null)
    {
        parent::__construct($name, $alias);

        $this->setFormat("H:i:s");
    }

}
