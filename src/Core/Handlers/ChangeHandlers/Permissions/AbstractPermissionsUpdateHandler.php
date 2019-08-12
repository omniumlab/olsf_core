<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2018
 * Time: 19:10
 */

namespace Core\Handlers\ChangeHandlers\Permissions;


use Core\Auth\Permissions\PermissionInterface;
use Core\Auth\Permissions\PermissionList;
use Core\Auth\Permissions\PermissionsFinderInterface;
use Core\Auth\Permissions\SubjectWithPermissionsInterface;
use Core\Auth\Permissions\SubjectWithPermissionsProviderInterface;
use Core\Exceptions\NotFoundException;
use Core\Exceptions\RestException;
use Core\Handlers\Handler;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractPermissionsUpdateHandler extends Handler
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
     * @param \Core\Auth\Permissions\PermissionsFinderInterface $permissionsFinder
     * @param TextHandlerInterface $textHandler
     */
    public function __construct(SubjectWithPermissionsProviderInterface $provider,
                                PermissionsFinderInterface $permissionsFinder, TextHandlerInterface $textHandler)
    {
        parent::__construct("PUT", true, $textHandler);
        $this->provider = $provider;
        $this->permissionsFinder = $permissionsFinder;
    }


    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Core\Exceptions\RestException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $subject = $this->getSubject(intval($command->getUrlIdParameter()));
        $subjectPermissions = $this->getSubjectPermissions($subject);
        $allPermissions = $this->getAllPermissions();

        foreach ($allPermissions as $permission) {
            $enabled = $command->get($permission->getName(), null);

            if ($enabled === null) {
                continue;
            }

            $permission->setEnabled((bool)$enabled);
            $subjectPermissions->setPermission($permission);
        }
        $subject->setPermissionsString($subjectPermissions->getPermissionsString());
        $subject->save();

        return new SuccessHandlerResponse(200, [], $this->getTextHandler()->get("success_permissions_handler_response_text" ));
    }

    /**
     * @param int $id
     *
     * @return \Core\Auth\Permissions\SubjectWithPermissionsInterface
     * @throws \Core\Exceptions\NotFoundException
     */
    private function getSubject(int $id): SubjectWithPermissionsInterface
    {
        $subject = $this->provider->getSubjectWithPermissionsById($id);

        if ($subject === null) {
            throw new NotFoundException();
        }

        return $subject;
    }

    /**
     * @param \Core\Auth\Permissions\SubjectWithPermissionsInterface $subject
     *
     * @return \Core\Auth\Permissions\PermissionListInterface|null
     * @throws \Core\Exceptions\RestException
     */
    private function getSubjectPermissions(SubjectWithPermissionsInterface $subject)
    {
        $permissions = $subject->getPermissionList();

        if ($permissions && $permissions->isSuperadmin()) {
            throw new RestException(400, $this->getTextHandler()->get("failure_permissions_handler_response_text"));
        }

        return $permissions ? $permissions : new PermissionList();
    }

    /**
     * @return PermissionInterface[]
     */
    protected function getAllPermissions(): array
    {
        return $this->permissionsFinder->getAllPermissions()->getAll();
    }

}
