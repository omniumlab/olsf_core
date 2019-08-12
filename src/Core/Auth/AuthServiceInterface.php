<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 15/06/2018
 * Time: 17:11
 */

namespace Core\Auth;


use Core\Auth\User\AuthUserInterface;
use Core\Commands\CommandInterface;
use Core\Handlers\HandlerInterface;
use Core\Output\Responses\HandlerResponseInterface;

interface AuthServiceInterface
{
    public function getCurrentConnectedUser(): ?AuthUserInterface;

    /**
     * @param \Core\Handlers\HandlerInterface $handler
     *
     * @return mixed
     */
    public function doAuth(HandlerInterface $handler);

    /**
     * Evento lanzado justo antes de devolver la respuesta al usuario desde el controlador. Usada para que el servicio
     * actualice la sesión, establezca las cookies o cabeceras necesarias.
     *
     * @param \Core\Output\Responses\HandlerResponseInterface $response
     *
     * @return void
     */
    public function onBeforeResponse(HandlerResponseInterface $response): void;
}
