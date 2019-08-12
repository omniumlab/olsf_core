<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 05/12/2017
 * Time: 19:59
 */

namespace Core\Handlers\ConfigHandler;

use Core\Config\GlobalConfigInterface;
use Core\Entities\EntityInterface;
use Core\Text\SymfonyTextHandler;


/**
 * Menu class to compose the panel menu. It uses the entities allowed to add or remove items and send only the allowed
 * items
 *
 * @package OLSF\PanelBundle\Entity
 */
class Menu implements MenuInterface
{
    private $menu = [];

    /**
     * @var EntityInterface[]
     */
    private $entitiesAllowed;
    /**
     * @var SymfonyTextHandler
     */
    private $textHandler;

    /**
     * Menu constructor.
     *
     * @param \Core\Config\GlobalConfigInterface $config
     * @param SymfonyTextHandler $textHandler
     */
    public function __construct(GlobalConfigInterface $config, SymfonyTextHandler $textHandler)
    {
        $this->menu = $config->getMenu();
        $this->textHandler = $textHandler;
    }

    /**
     * Get the menu to send to the client. Receives the list of entities allowed to remove items not allowed.
     *
     * @param $entitiesAllowed EntityInterface[]
     *
     * @return array Menu array filtered with items allowed by the current user
     */
    public function getMenu($entitiesAllowed)
    {
        $this->entitiesAllowed = $entitiesAllowed;

        return $this->getMenuCategoryChildren($this->menu);
    }

    /**
     * Get the children of this category removing those not allowed. If none of the children are allowed, the category
     * is not allowed and will not be added to the menu
     *
     * @param array $parentCategory
     *
     * @return array
     */
    private function getMenuCategoryChildren(array $parentCategory)
    {
        $options = [];
        $children = [];
        foreach ($parentCategory as $key => $value) {
            if (substr($key, 0, 2) == "##")
                $key = $this->textHandler->get(str_replace('##', '', $key));
            if ($this->isOption($key)) {
                $options[$key] = $value;
                continue;
            }

            if ($this->isLink($value) && !$this->isEntityAllowed($value["_entity_name"])) {
                continue;
            }

            if ($this->isCategory($value)) {
                $value = $this->getMenuCategoryChildren($value);

                if (!$value) {
                    continue;
                }
            }

            $children[$key] = $value;

        }

        if ($children) {
            $children = array_merge($options, $children);
        }

        return $children;
    }

    /**
     * Check if the key name from the array is an option
     *
     * @param string $keyName
     *
     * @return bool True if the key name is an option (starts with "_"). False otherwise.
     */
    private function isOption($keyName)
    {
        return $keyName[0] == "_";
    }

    /**
     * Check if the menu item value is a link
     *
     * @param mixed $itemMenu
     *
     * @return bool True if the parameter is an array an is not a category (isCategory() == false)
     */
    private function isLink($itemMenu)
    {
        return is_array($itemMenu) && !$this->isCategory($itemMenu);
    }

    /**
     * Check if the menu item value is a category
     *
     * @param $itemMenu
     *
     * @return bool True if the parameter is an array and it hasn't the key "_entity_name"
     */
    private function isCategory($itemMenu)
    {
        return is_array($itemMenu) && !isset($itemMenu["_entity_name"]);
    }

    /**
     * Checks if the entity is allowed
     *
     * @param $entityName
     *
     * @return bool True if the entity is allowed
     */
    private function isEntityAllowed($entityName)
    {
        foreach ($this->entitiesAllowed as $entity) {
            if ($entity->getName() === $entityName) {
                return true;
            }
        }

        return false;
    }

}