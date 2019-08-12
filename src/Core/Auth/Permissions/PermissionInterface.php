<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 17/11/2017
 * Time: 7:58
 */

namespace Core\Auth\Permissions;


interface PermissionInterface
{
    /**
     * @return string
     */
    function getName();

    /**
     * @return string
     */
    function __toString();

    /**
     * @return bool
     */
    function isEnabled();

    /**
     * @return bool
     */
    function isInWhiteList();


    /**
     * Marca este permiso como no revocable.
     */
    public function setNotRevocable(): void;

    /**
     * @param bool $revocable
     * @return $this
     */
    public function setRevocable(bool $revocable);

    /**
     * @return bool True si el permiso es revocable. False si no lo es.
     */
    public function isRevocable(): bool;

    public function setEnabled(bool $enabled);
}
