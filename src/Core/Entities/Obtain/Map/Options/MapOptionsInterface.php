<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:49
 */

namespace Core\Entities\Obtain\Map\Options;


interface MapOptionsInterface
{
    /**
     * @param string $url
     * @return $this
     */
    function setUrl(string $url);
}
