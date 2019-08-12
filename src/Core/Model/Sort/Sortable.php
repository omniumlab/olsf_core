<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 30/01/2018
 * Time: 13:22
 */

namespace Core\Model\Sort;


interface Sortable
{
    /**
     * @param $v
     * @param bool $correlatively
     *
     * @return Sortable
     */
    public function setSort($v, $correlatively = true);

    public function save();
}