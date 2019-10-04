<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 06/04/2018
 * Time: 12:18
 */

namespace Core\Handlers;


use Core\Auth\Permissions\PermissionInterface;
use Core\Auth\Roles\RoleInterface;
use Core\Commands\CommandInterface;
use Core\Fields\Output\Text;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Reflection\NameInterface;
use Core\Text\TextHandlerInterface;

interface HandlerInterface
{
    const TYPE_TEXT = "text";
    const TYPE_SELECT = "select";
    const TYPE_TEXTAREA = "textarea";
    const TYPE_RICH_TEXT_EDITOR = "richtexteditor";
    const TYPE_CHECKBOX = "checkbox";
    const TYPE_HIDDEN = "hidden";
    const TYPE_DATETIME = "datetime";
    const TYPE_DATE = "date";
    const TYPE_TIME = "time";
    const TYPE_DATE_NO_RANGE = "datenorange";
    const TYPE_FILE = "file";
    const TYPE_RADIO = "radio";
    const TYPE_PASSWORD = "password";
    const TYPE_AUTOCOMPLETE = "autocomplete";
    const TYPE_LIST_QUERY = "listquery";
    const TYPE_IMAGE = "image";

    public function getName(): NameInterface;

    public function getResourceName(): NameInterface;

    public function getHttpMethod(): string;

    public function isIndividual(): bool;

    public function getPermission(): PermissionInterface;

    public function setPermission(string $permission);

    public function getUrl($id = '{id}'): string;

    /**
     * Mínimo rol requerido para ejecutar este handler.
     *
     * @return \Core\Auth\Roles\RoleInterface|null
     */
    public function getMininumRole(): ?RoleInterface;

    public function setup();

    /**
     * @param string $key
     * @param array $params
     * @param string|null $method
     */
    public function setLogResponse(string $key, array $params = [], string $method = null);
    /**
     */
    public function getLogResponse():array ;
    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface;
}
