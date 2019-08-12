<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/11/2017
 * Time: 7:51
 */

namespace Core\Auth\Permissions;


interface PermissionListInterface
{
    /**
     * @return string
     */
    public function getPermissionsString();

    /**
     * @return string
     */
    public function __toString();

    /**
     * Comprueba si el permiso especificado existe y está habilitado.
     *
     * @param PermissionInterface|string $permission
     *
     * @return bool|null True si tiene el permiso. False si no tiene el permiso. Null si no se ha encontrado el permiso
     */
    public function hasPermission($permission): ?bool;

    /**
     * @param PermissionInterface $permissionToSet
     *
     * @return mixed
     *
     */
    public function setPermission(PermissionInterface $permissionToSet);

    /**
     * @return bool True if the subject is superadmin. False otherwise.
     */
    public function isSuperadmin();

    /**
     * Actualiza los permisos con los que vienen en el parámetro. Los que no existan se añaden y los que sí existan se
     * actualiza el valor en caso de ser distinto
     *
     * @param \Core\Auth\Permissions\PermissionListInterface $permissions
     *
     * @return mixed
     */
    public function updateWith(PermissionListInterface $permissions);

    /**
     * @return \Core\Auth\Permissions\PermissionInterface[]
     */
    public function getAll(): array;

    /**
     * @return array Todos los permisos en la forma [name => enabled]
     */
    public function toArray(): array;
}
