<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 16/11/2017
 * Time: 12:51
 */

namespace Core\Auth\Permissions;


/**
 * Class Permission
 *
 * @package OLSF\PermissionsBundle\Entities
 *
 */
class Permission implements PermissionInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $enabled = false;
    /**
     * @var bool
     */
    private $revocable = true;

    /**
     * Permission constructor.
     *
     * @param string $name Nombre del permiso
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return bool
     * @deprecated Confirmar que no hace falta.
     */
    public function isInWhiteList()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = (bool)$enabled;
    }

    function __toString()
    {
        return $this->getName() . "|" . ($this->isEnabled() ? "1" : "0");
    }

    public static function createFromString($permissionString)
    {
        $permissionData = explode("|", $permissionString);

        if (count($permissionData) != 2) {
            return null;
        }

        $permission = new Permission($permissionData[0]);
        $permission->setEnabled($permissionData[1]);

        return $permission;
    }


    /**
     * Marca este permiso como no revocable.
     */
    public function setNotRevocable(): void
    {
        $this->revocable = false;
    }

    public function setRevocable(bool $revocable)
    {
        $this->revocable = $revocable;
        return $this;
    }

    /**
     * @return bool True si el permiso es revocable. False si no lo es.
     */
    public function isRevocable(): bool
    {
        return $this->revocable;
    }
}
