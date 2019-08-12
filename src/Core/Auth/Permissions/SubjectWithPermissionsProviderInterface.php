<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/07/2018
 * Time: 18:26
 */

namespace Core\Auth\Permissions;


interface SubjectWithPermissionsProviderInterface
{
    public function getSubjectWithPermissionsById(int $id): ?SubjectWithPermissionsInterface;
}