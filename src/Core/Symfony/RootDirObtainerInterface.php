<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/09/2018
 * Time: 12:37
 */

namespace Core\Symfony;


interface RootDirObtainerInterface
{
    /**
     * @return string
     */
    function getRootDir(): string;

    function getPublicDir(): string;

    /** @return string */
    function getUrlBase(): string;
}
