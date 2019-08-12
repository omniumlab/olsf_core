<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/07/2018
 * Time: 20:27
 */

namespace Core\Auth\Roles;


use Core\Auth\User\UserProviderInterface;

class RoleBase implements RoleInterface
{
    /**
     * @var \Core\Auth\Roles\RoleInterface
     */
    private $parent;

    /**
     * @var string
     */
    private $name;
    /**
     * @var \Core\Auth\User\UserProviderInterface
     */
    private $userProvider;

    /**
     * RoleBase constructor.
     *
     * @param string $name
     * @param \Core\Auth\Roles\RoleInterface $parent
     * @param \Core\Auth\User\UserProviderInterface $userProvider
     */
    public function __construct(string $name, $parent, UserProviderInterface $userProvider)
    {
        if (!($parent instanceof RoleInterface) && $parent !== null) {
            throw new \InvalidArgumentException("The \$parent parameter for " . get_class($this) . " is incorrect");
        }

        $this->parent = $parent;
        $this->name = $name;
        $this->userProvider = $userProvider;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|\Core\Auth\Roles\RoleInterface Padre de este rol o null si no tiene padre.
     */
    public function getParent(): ?RoleInterface
    {
        return $this->parent;
    }

    /**
     * @param \Core\Auth\Roles\RoleInterface $role
     *
     * @return bool True si $role es hijo de este Rol o si es el mismo.
     */
    public function isParentOf(RoleInterface $role): bool
    {
        if ($this->getName() === $role->getName()) {
            return true;
        }

        $parent = $role->getParent();

        if ($parent === null) {
            return false;
        }

        return $this->isParentOf($parent);
    }

    public function getUserProvider(): ?UserProviderInterface
    {
        return $this->userProvider;
    }
}