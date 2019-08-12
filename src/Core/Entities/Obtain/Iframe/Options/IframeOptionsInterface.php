<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:49
 */

namespace Core\Entities\Obtain\Iframe\Options;


interface IframeOptionsInterface
{
    /**
     * @param string $url
     * @return $this
     */
    function setUrl(string $url);
}
