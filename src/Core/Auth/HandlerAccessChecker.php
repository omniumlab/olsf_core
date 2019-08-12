<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 09/07/2018
 * Time: 10:12
 */

namespace Core\Auth;


use Core\Auth\Permissions\PermissionInterface;
use Core\Auth\Permissions\SubjectWithPermissionsInterface;
use Core\Auth\Roles\AnonymousRole;
use Core\Auth\Roles\RoleInterface;
use Core\Auth\Roles\SuperadminRoleInterface;
use Core\Auth\User\AuthUserInterface;
use Core\Exceptions\PermissionDeniedException;
use Core\Exceptions\PermissionNotFoundException;
use Core\Handlers\HandlerInterface;

class HandlerAccessChecker implements HandlerAccessCheckerInterface
{

    private $superadminRole;

    /** @var AnonymousRole */
    private $anonymousRole;

    /**
     * HandlerAccessChecker constructor.
     * @param SuperadminRoleInterface $superadminRole Se a de especificar que clase será injectada.
     * @param AnonymousRole $anonymousRole
     */
    function __construct(SuperadminRoleInterface $superadminRole, AnonymousRole $anonymousRole)
    {
        $this->superadminRole = $superadminRole;
        $this->anonymousRole = $anonymousRole;
    }

    /**
     * @param \Core\Handlers\HandlerInterface $handler
     * @param \Core\Auth\User\AuthUserInterface $user
     *
     * @throws \Core\Exceptions\PermissionDeniedException
     */
    public function checkAccess(HandlerInterface $handler, AuthUserInterface $user)
    {
        $this->checkRole($handler, $user);
        $this->checkPermissions($handler, $user);
    }


    private function getUserRole(AuthUserInterface $user): RoleInterface
    {
        $userRole = $user->getRole();

        if ($userRole === null) {
            $userRole = $this->anonymousRole;
        }elseif ($userRole instanceof SubjectWithPermissionsInterface && $userRole->getPermissions() === "superadmin"){
            $userRole = $this->superadminRole;
        }

        return $userRole;
    }

    /**
     * @param \Core\Handlers\HandlerInterface $handler
     *
     * @param \Core\Auth\User\AuthUserInterface $user
     *
     * @throws \Core\Exceptions\PermissionDeniedException
     */
    private function checkRole(HandlerInterface $handler, AuthUserInterface $user): void
    {
        $userRole = $this->getUserRole($user);

        $mininumRole = $handler->getMininumRole();

        if ($mininumRole === null) {
            $mininumRole = $this->anonymousRole;
        }

        if (!$mininumRole->isParentOf($userRole)) {
            throw new PermissionDeniedException();
        }
    }

    /**
     * @param \Core\Handlers\HandlerInterface $handler
     *
     * @param \Core\Auth\User\AuthUserInterface $user
     *
     * @throws \Core\Exceptions\PermissionDeniedException
     */
    private function checkPermissions(HandlerInterface $handler, AuthUserInterface $user): void
    {
        $permissionToCheck = $handler->getPermission();

        if ($permissionToCheck === null) {
            throw new \InvalidArgumentException("Handler " . get_class($this) . " must have a permission. Null detected");
        }

        if (!$permissionToCheck->isRevocable()) {
            return;
        }

        $role = $this->getUserRole($user);

        if (!($role instanceof SubjectWithPermissionsInterface)) {
            throw new \LogicException("Role " . get_class($role) . " must implements " .
                                      SubjectWithPermissionsInterface::class . " because " . get_class($handler) .
                                      " has a revocable permission");
        }

        try {
            if ($user instanceof SubjectWithPermissionsInterface) {
                $this->checkPermission($user, $permissionToCheck);
            } else {
                $this->checkRolePermission($role, $permissionToCheck);
            }
        } catch (PermissionNotFoundException $exception) {
            $this->checkRolePermission($role, $permissionToCheck);
        }
    }

    /**
     * @param \Core\Auth\Permissions\SubjectWithPermissionsInterface $role
     * @param \Core\Auth\Permissions\PermissionInterface $permission
     *
     * @throws \Core\Exceptions\PermissionDeniedException
     */
    private function checkRolePermission(SubjectWithPermissionsInterface $role, PermissionInterface $permission)
    {
        try {
            $this->checkPermission($role, $permission);
        } catch (PermissionNotFoundException $notFoundException) {
            throw new PermissionDeniedException("Permission denied", 401, $notFoundException);
        }
    }

    /**
     * @param \Core\Auth\Permissions\SubjectWithPermissionsInterface $subject
     * @param \Core\Auth\Permissions\PermissionInterface $permission
     *
     * @throws \Core\Exceptions\PermissionDeniedException
     * @throws \Core\Exceptions\PermissionNotFoundException
     */
    private function checkPermission(SubjectWithPermissionsInterface $subject, PermissionInterface $permission)
    {
        $permissions = $subject->getPermissionList();

        if ($permissions === null) {
            throw new PermissionNotFoundException();
        }

        if (!$permissions->hasPermission($permission)) {
            throw new PermissionDeniedException();
        }
    }
}
