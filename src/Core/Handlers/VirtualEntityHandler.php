<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 18:28
 */

namespace Core\Handlers;


use Core\Auth\Permissions\Permission;
use Core\Auth\Permissions\PermissionInterface;
use Core\Auth\Roles\RoleInterface;
use Core\Commands\CommandInterface;
use Core\Entities\EntityTypeInterface;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Reflection\Name;
use Core\Reflection\NameInterface;

final class VirtualEntityHandler implements HandlerInterface
{
    /**
     * @var \Core\Reflection\NameInterface
     */
    private $resourceName;

    /**
     * @var \Core\Reflection\Name
     */
    private $name;
    /**
     * @var PermissionInterface
     */
    private $permission;
    /**
     * @var \Core\Auth\Roles\RoleInterface
     */
    private $minimumRole;

    /** @var [] */
    private $logResponse;
    /**
     * VirtualHandler constructor.
     *
     * @param \Core\Reflection\NameInterface $resourceName
     * @param \Core\Entities\EntityTypeInterface $entityType
     * @param \Core\Auth\Roles\RoleInterface $minimumRole
     */
    public function __construct(NameInterface $resourceName, EntityTypeInterface $entityType,
                                ?RoleInterface $minimumRole = null)
    {
        $this->resourceName = $resourceName;
        $this->name = new Name($resourceName->getSnakeCase() . "_" . $entityType->getName());
        $this->permission = new Permission($this->getName()->getSnakeCase());
        $this->minimumRole = $minimumRole;
    }

    public function getName(): NameInterface
    {
        return $this->name;
    }

    public function getResourceName(): NameInterface
    {
        return $this->resourceName;
    }

    public function setResourceName(NameInterface $resourceName)
    {
        $this->resourceName = $resourceName;
    }

    public function getHttpMethod(): string
    {
        return "";
    }

    public function isIndividual(): bool
    {
        return false;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        throw new \LogicException("Cannot call the execute method of a virtual handler");
    }

    public function getPermission(): PermissionInterface
    {
        return $this->permission;
    }

    public function getUrl($id = "{id}"): string
    {
        return "";
    }

    /**
     * Mínimo rol requerido para ejecutar este handler.
     *
     * @return \Core\Auth\Roles\RoleInterface|null
     */
    public function getMininumRole(): ?RoleInterface
    {
        return $this->minimumRole;
    }

    public function setup()
    {

    }

    public function setPermission(string $permission)
    {

    }

    public function setLogResponse(string $key, array $params = [], string $method = null)
    {
        $this->logResponse["data"] = $key;
        $this->logResponse["params"] = $params;
        if ($method !== null) $this->logResponse["method"] = $method;

    }

    public function getLogResponse(): array
    {
        return $this->logResponse;
    }
}