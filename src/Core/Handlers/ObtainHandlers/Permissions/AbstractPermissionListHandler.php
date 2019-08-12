<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2018
 * Time: 18:25
 */

namespace Core\Handlers\ObtainHandlers\Permissions;


use Core\Auth\Permissions\PermissionListInterface;
use Core\Auth\Permissions\PermissionsFinderInterface;
use Core\Auth\Permissions\SubjectWithPermissionsProviderInterface;
use Core\Exceptions\NotFoundException;
use Core\Exceptions\SuperadminPermissionsException;
use Core\Handlers\Handler;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractPermissionListHandler extends Handler implements PermissionsListHandlerInterface
{
    /**
     * @var \Core\Auth\Permissions\SubjectWithPermissionsProviderInterface
     */
    private $provider;
    /**
     * @var \Core\Auth\Permissions\PermissionsFinderInterface
     */
    private $permissionsFinder;

    /**
     * Handler constructor.
     *
     * @param \Core\Auth\Permissions\SubjectWithPermissionsProviderInterface $provider
     * @param TextHandlerInterface $textHandle
     * @param \Core\Auth\Permissions\PermissionsFinderInterface $permissionsFinder
     */
    public function __construct(SubjectWithPermissionsProviderInterface $provider,
                                TextHandlerInterface $textHandle,
                                PermissionsFinderInterface $permissionsFinder)
    {
        parent::__construct("GET", true, $textHandle);

        $this->provider = $provider;
        $this->permissionsFinder = $permissionsFinder;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Core\Exceptions\SuperadminPermissionsException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $subject = $this->provider->getSubjectWithPermissionsById(intval($command->getUrlIdParameter()));

        if ($subject === null) {
            throw new NotFoundException();
        }

        if ($subject->isSuperadmin()) {
            throw new SuperadminPermissionsException();
        }

        $subjectPermissions = $subject->getPermissionList();
        $permissions = $this->getAllPermissions($subjectPermissions);
        $subjectPermissions = $subjectPermissions ? $subjectPermissions->toArray() : [];
        $permissions = array_merge($permissions, $subjectPermissions);

        return new SuccessHandlerResponse(200, $permissions);
    }

    protected function getAllPermissions(?PermissionListInterface $subjectPermissions): array
    {
        return $this->permissionsFinder->getAllPermissions($subjectPermissions)->toArray();
    }

}
