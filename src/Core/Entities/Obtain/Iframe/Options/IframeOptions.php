<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:49
 */

namespace Core\Entities\Obtain\Iframe\Options;


use Core\Entities\Options\EntityOptions;
use Core\Entities\Obtain\Iframe\Options\IframeOptionsInterface;

class IframeOptions extends EntityOptions implements IframeOptionsInterface
{
    /*
     * url: string
     */


    /**
     * @param string $url
     * @return $this
     */
    function setUrl(string $url)
    {
        $this->setVariable("url", $url);
        return $this;
    }
}
