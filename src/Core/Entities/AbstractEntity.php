<?php

namespace Core\Entities;

use Core\Auth\Permissions\PermissionInterface;
use Core\Entities\Options\Action;
use Core\Entities\Options\ActionInterface;
use Core\ListValue\BaseListValue;
use Core\Entities\Options\EntityOptions;
use Core\Entities\Options\EntityOptionsInterface;

use Core\Handlers\HandlerInterface;
use Core\ListValue\ValueInterface;
use Core\Text\TextHandlerInterface;


abstract class AbstractEntity implements EntityInterface, ValueInterface
{
    /**
     * @var BaseListValue Class variables
     * "name" string
     * "type" string
     * "url" string
     * "restPrefixUrl" string
     * "method" string
     * "options" BaseEntityOptions
     * "geolocation" bool
     */
    private $variables;

    /**
     * @var ActionInterface
     */
    private $action;

    /**
     * @var EntityTypeInterface
     */
    private $entityType;
    /**
     * @var \Core\Handlers\HandlerInterface
     */
    private $handler;
    /**
     * @var TextHandlerInterface
     */
    private $textHandler;

    /**
     * BaseEntity constructor.
     *
     * @param \Core\Handlers\HandlerInterface $handler
     * @param \Core\Entities\EntityTypeInterface $entityType
     * @param TextHandlerInterface $textHandler For getting the visual name
     */
    function __construct(HandlerInterface $handler, EntityTypeInterface $entityType,
                         TextHandlerInterface $textHandler)
    {
        $this->variables = new BaseListValue();
        $this->action = new Action($this);
        $this->entityType = $entityType;
        $this->handler = $handler;
        $this->textHandler = $textHandler;

        $this->setBaseParameters($textHandler);
        $this->setUrl($handler->getUrl());
        $this->setHttpMethod($handler->getHttpMethod());
        $handler->setup();
        $this->setOptions(new EntityOptions());

        $this->getAction()->setVisualName($this->getVisualName());
    }

    private function setBaseParameters(TextHandlerInterface $textHandler)
    {
        $entityName = $this->handler->getResourceName()->getSnakeCase() . "_" . $this->handler->getName()->getSnakeCase();

        $this->setVariable("type", $this->entityType->getName());
        $this->setVariable("permissionName", $this->handler->getPermission()->getName());
        $this->setVariable("name", $entityName);
        $this->setVariable("visualName", $textHandler->get("entity." . $entityName));
    }

    protected function setHttpMethod(string $httpMethod)
    {
        if ($httpMethod) {
            $this->setVariable("method", $httpMethod);
        }
    }

    public function getUrl(): string
    {
        return $this->getVariable("url");
    }

    public function setUrl(string $url)
    {
        if ($url) {
            $this->setVariable("url", $url);
        }
    }

    public function getVariable($variableName)
    {
        return $this->variables->getValue($variableName);
    }

    public function setVariable($variableName, $value)
    {
        $this->variables->setValue($value, $variableName);
    }

    public function getName()
    {
        return $this->getVariable("name");
    }

    public function setName(string $name)
    {
        $this->setVariable("name", $name);
    }


    /**
     * @return mixed
     */
    public function getValues()
    {
        $this->setup($this->textHandler);
        return $this->variables->getValues();
    }

    /**
     * @param $restPrefixUrl string
     */
    public function setRestPrefixUrl($restPrefixUrl)
    {
        $this->setVariable("restPrefixUrl", $restPrefixUrl);
    }

    /**
     * @return EntityOptionsInterface
     */
    public function getOptions()
    {
        return $this->getVariable("options");
    }

    public function setOptions(EntityOptionsInterface $options)
    {
        $this->setVariable("options", $options);
    }

    /**
     * @return \Core\Entities\Options\Action
     */
    public function getAction()
    {
        return $this->action;
    }

    public function getHttpMethod(): string
    {
        return $this->getVariable("method");
    }

    public function getVisualName(): string
    {
        return $this->getVariable("visualName") ?? "";
    }

    /**
     * @param string $visualName
     */
    public function setVisualName(string $visualName)
    {
        $this->setVariable("visualName", $visualName);
    }

    /**
     * @return \Core\Entities\EntityTypeInterface
     */
    public function getEntityType(): EntityTypeInterface
    {
        return $this->entityType;
    }

    /**
     * @return \Core\Handlers\HandlerInterface
     */
    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    public function getPermission(): PermissionInterface
    {
        return $this->getHandler()->getPermission();
    }

    public function setPermission(string $permission)
    {
        $this->getHandler()->setPermission($permission);
        $this->setVariable("permissionName", $permission);
    }

    public function getGeolocation(): bool
    {
        return $this->getVariable("geolocation");
    }

    public function setGeolocation(bool $geolocation): EntityInterface
    {
        $this->setVariable("geolocation", $geolocation);
        return $this;
    }

    public function setup(TextHandlerInterface $textHandler)
    {

    }
    public function setSaveEntityName(string $entityName)
    {
        $this->setVariable("saveEntityUrl", $entityName);
    }

    /**
     * @return TextHandlerInterface
     */
    protected function getTextHandler(): TextHandlerInterface
    {
        return $this->textHandler;
    }
}
