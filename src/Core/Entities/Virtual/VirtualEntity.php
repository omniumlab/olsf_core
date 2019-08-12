<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 19:20
 */

namespace Core\Entities\Virtual;


use Core\Auth\Roles\RoleInterface;
use Core\Entities\AbstractEntity;
use Core\Entities\EntityTypeInterface;
use Core\Handlers\VirtualEntityHandler;
use Core\Reflection\Name;
use Core\Reflection\NameInterface;
use Core\Text\TextHandlerInterface;

class VirtualEntity extends AbstractEntity
{
    /**
     * BaseEntity constructor.
     *
     * @param \Core\Entities\EntityTypeInterface $entityType
     * @param TextHandlerInterface $textHandler For getting the visual name
     * @param RoleInterface $minRole
     */
    public function __construct( EntityTypeInterface $entityType,
                                TextHandlerInterface $textHandler,
                                RoleInterface $minRole = null)
    {

        $handler = new VirtualEntityHandler($this->getHandlerName(), $entityType, $minRole);
        $handler->setResourceName(new Name(explode("\\", get_class($this))[1]));

        parent::__construct($handler, $entityType, $textHandler);
        $this->configUrl();
    }


    private function getHandlerName(): NameInterface
    {
        return new Name(get_class($this), "Entity");
    }

    private function configUrl()
    {
        $url = $this->getHandler()->getResourceName()->getSnakeCase();

        $handlerName = $this->getHandler()->getName()->getSnakeCase();
        if ($handlerName !== "default") {
            $url .= "/" . $handlerName;
        }

        $this->setUrl($url);
    }

}
