<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2018
 * Time: 11:32
 */

namespace Core\Handlers\ObtainHandlers\Map;


use Core\Handlers\HandlerInterface;

interface MapHandlerInterface extends HandlerInterface
{
    public function setCenter($coordinate);
    public function setZoom(int $zoom);
    public function addMarker($latitude, $longitude,$textDialog = null, $titleDialog = null, $iconbase64 = null);
}