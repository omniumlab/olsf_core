<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2018
 * Time: 19:18
 */

namespace Core\Auth\Permissions;


use Core\Reflection\Finders\ResourcesFinderInterface;
use Core\Resource\ResourceInterface;

class PermissionsFinder implements PermissionsFinderInterface
{
    /**
     * @var \Core\Reflection\Finders\ResourcesFinderInterface
     */
    private $resourcesFinder;


    /**
     * PermissionsFinder constructor.
     *
     * @param \Core\Reflection\Finders\ResourcesFinderInterface $resourcesFinder
     */
    public function __construct(ResourcesFinderInterface $resourcesFinder)
    {
        $this->resourcesFinder = $resourcesFinder;
    }

    public function getAllPermissions(?PermissionListInterface $subjectPermissions = null): PermissionListInterface
    {
        $permissions = new PermissionList();

        foreach ($this->resourcesFinder->getAllResources() as $resource) {
            $this->addResourcePermissions($resource, $subjectPermissions, $permissions);
        }

        return $permissions;
    }

    private function addResourcePermissions(ResourceInterface $resource, ?PermissionListInterface $subjectPermissions,
                                            PermissionListInterface &$permissions)
    {
        foreach ($resource->getEntities() as $entity) {
            $permissionToFind = $entity->getHandler()->getPermission();

            if ($permissionToFind->isRevocable()) {
                $permissions->setPermission($permissionToFind);

                if ($subjectPermissions !== null) {
                    $subjectPermissionEnabled = !!$subjectPermissions->hasPermission($permissionToFind);

                    $permissionToFind->setEnabled($subjectPermissionEnabled);
                }
            }
        }
    }
}