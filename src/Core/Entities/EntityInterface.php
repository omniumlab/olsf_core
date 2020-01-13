<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 20/10/2017
 * Time: 18:21
 */

namespace Core\Entities;


use Core\Auth\Permissions\PermissionInterface;
use Core\Entities\Options\EntityOptionsInterface;
use Core\Handlers\HandlerInterface;
use Core\Text\TextHandlerInterface;

interface EntityInterface
{
    public function getName();

    public function setName(string $name);

    public function getVisualName(): string;

    public function setUrl(string $url);

    public function getUrl(): string;
    public function setSaveEntityName(string $entityName);
    /**
     * @param string $visualName
     */
    public function setVisualName(string $visualName);

    public function getPermission(): PermissionInterface;

    public function setPermission(string $permission);

    /** @return string */
    public function getHttpMethod(): string;

    /**
     * @return \Core\Entities\EntityTypeInterface
     */
    public function getEntityType(): EntityTypeInterface;

    public function getGeolocation(): bool;

    public function setGeolocation(bool $geolocation): EntityInterface;

    /**
     * @return \Core\Entities\Options\Action
     */
    public function getAction();

    /**¡
     * @param TextHandlerInterface $textHandler
     */
    public function setup(TextHandlerInterface $textHandler);

    /**
     * Devuelve el handler asociado a esta entidad.
     *
     * @return \Core\Handlers\HandlerInterface
     */
    public function getHandler(): HandlerInterface;
}
