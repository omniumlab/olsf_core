<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/04/2018
 * Time: 20:53
 */

namespace Core\Handlers\ConfigHandler;

use Core\Entities\EntityInterface;


/**
 * Menu class to compose the panel menu. It uses the entities allowed to add or remove items and send only the allowed
 * items
 *
 * @package OLSF\PanelBundle\Entity
 */
interface MenuInterface
{
    /**
     * Get the menu to send to the client. Receives the list of entities allowed to remove items not allowed.
     *
     * @param $entitiesAllowed EntityInterface[]
     *
     * @return array Menu array filtered with items allowed by the current user
     */
    public function getMenu($entitiesAllowed);
}