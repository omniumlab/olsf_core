<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/04/2018
 * Time: 19:58
 */

namespace Core\Handlers\ObtainHandlers;


use Core\Handlers\HandlerInterface;
use Core\Handlers\ObtainHandlers\Propel\ListHandler\Summatory;

interface ListHandlerInterface extends HandlerInterface
{
    /**
     * Method to get summations of this list
     *
     * @return \Core\Handlers\ObtainHandlers\Propel\ListHandler\Summatory[]
     */
    public function getSummaries() : array;

    /**
     * @return int
     */
    public function getCount();

    public function setIdParent($id);

    /**
     * @return \Core\Fields\Output\OutputFieldInterface[]
     */
    public function getFields(): array;
}