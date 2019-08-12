<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 07/12/2017
 * Time: 13:19
 */

namespace Core\Entities\Obtain\PermissionEntity;

use Core\Handlers\ObtainHandlers\Permissions\PermissionsListHandlerInterface;
use Core\Text\TextHandlerInterface;

class PermissionListEntity extends AbstractPermissionEntity implements PermissionListEntityInterface
{
    public function __construct(PermissionsListHandlerInterface $permissionsListHandler, TextHandlerInterface $text)
    {
        parent::__construct($permissionsListHandler, new PermissionType(), $text);

        $this->getAction()->setIcon("fa-check")->setOnlyIcon(true);
        $this->setOptions(new PermissionListOptions());
    }

    /**
     * @return \Core\Entities\Options\EntityOptionsInterface|\Core\Entities\Obtain\PermissionEntity\PermissionListOptions
     */
    public function getOptions()
    {
        return parent::getOptions();
    }

}