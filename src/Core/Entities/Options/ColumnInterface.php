<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/10/2017
 * Time: 22:15
 */

namespace Core\Entities\Options;


interface ColumnInterface
{

    /**
     * @return string
     */
    public function convertNameToVisualName();

}