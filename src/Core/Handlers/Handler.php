<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/02/2018
 * Time: 15:18
 */

namespace Core\Handlers;


use Core\Auth\Permissions\Permission;
use Core\Auth\Permissions\PermissionInterface;
use Core\Auth\Roles\AbstractRegularUserRole;
use Core\Auth\Roles\AnonymousRole;
use Core\Fields\Output\Text;
use Core\Reflection\NameInterface;
use Core\Resource\ResourceName;
use Core\Text\TextHandlerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;

abstract class Handler implements HandlerInterface
{
    /**
     * @var string
     */
    private $httpMethod;
    /**
     * @var bool
     */
    private $individual;
    /**
     * @var PermissionInterface
     */
    private $permission;
    /**
     * @var TextHandlerInterface
     */
    private $textHandler;

    /** @var [] */
    private $logResponse = [];

    /**
     * Handler constructor.
     *
     * @param string $method
     * @param bool $individual
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(string $method, bool $individual, TextHandlerInterface $textHandler)
    {
        $this->httpMethod = $method;
        $this->individual = $individual;
        $this->textHandler = $textHandler;

        $this->createPermission();
    }


    public function setup()
    {

    }

    private function createPermission()
    {
        $permissionName = $this->getResourceName()->getSnakeCase();

        $handlerName = $this->getName()->getSnakeCase();

        if ($handlerName !== "default") {
            $permissionName .= "_" . $handlerName;
        }

        $this->permission = new Permission($permissionName);
        $minRole = $this->getMininumRole();
        if ($minRole instanceof AnonymousRole || $minRole instanceof AbstractRegularUserRole)
            $this->permission->setNotRevocable();
    }

    public function getResourceName(): NameInterface
    {
        $namespaceNodes = explode("\\", get_class($this));
        $camelCaseResourceName = "NoName";
        if (count($namespaceNodes) >= 3) {
            $camelCaseResourceName = $namespaceNodes[count($namespaceNodes) - 3];
        }

        return new ResourceName($camelCaseResourceName);
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @param string $httpMethod
     */
    public function setHttpMethod(string $httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }


    public function isIndividual(): bool
    {
        return $this->individual;
    }

    /**
     * @param bool $individual
     */
    public function setIndividual(bool $individual)
    {
        $this->individual = $individual;
    }

    public function getName(): NameInterface
    {
        return new HandlerName($this);
    }

    public function getUrl($id = "{id}"): string
    {
        $url = $this->getResourceName()->getSnakeCase();

        if ($this->isIndividual()) {
            $url .= "/" . $id;
        }

        $handlerName = $this->getName()->getSnakeCase();

        if ($handlerName !== "default") {
            $url .= "/" . $handlerName;
        }

        return $url;
    }

    public function getPermission(): PermissionInterface
    {
        return $this->permission;
    }

    public function setPermission(string $permission)
    {
        $this->permission = new Permission($permission);
    }

    /**
     * @return TextHandlerInterface
     */
    protected function getTextHandler(): TextHandlerInterface
    {
        return $this->textHandler;
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
