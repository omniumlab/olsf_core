<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:48
 */

namespace Core\Entities\Obtain\Map;


use Core\Entities\AbstractEntity;
use Core\Entities\Obtain\Iframe\Options\IframeOptions;
use Core\Entities\Obtain\Map\Options\MapOptions;
use Core\Entities\Options\EntityOptionsInterface;
use Core\Handlers\ObtainHandlers\Iframe\AbstractIframeHandler;
use Core\Handlers\ObtainHandlers\Map\AbstractMapHandler;
use Core\Text\TextHandlerInterface;

class MapEntity extends AbstractEntity
{
    public function __construct(AbstractMapHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new MapType(), $textHandler);
        $this->setOptions(new MapOptions());
    }

    /**
     * @return IframeOptions | EntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
