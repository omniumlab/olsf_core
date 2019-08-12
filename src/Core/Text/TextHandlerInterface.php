<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 08/04/2018
 * Time: 11:44
 */

namespace Core\Text;


interface TextHandlerInterface
{
    public function get(string $key, $parameters = []);
}