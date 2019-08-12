<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/02/2019
 * Time: 11:48
 */

namespace Core\Entities\Obtain\Iframe;


use Core\Entities\AbstractEntity;
use Core\Entities\Obtain\Iframe\Options\IframeOptions;
use Core\Entities\Options\EntityOptionsInterface;
use Core\Handlers\ObtainHandlers\Iframe\AbstractIframeHandler;
use Core\Text\TextHandlerInterface;

class IframeEntity extends AbstractEntity
{
    public function __construct(AbstractIframeHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new IframeType(), $textHandler);
        $this->setOptions(new IframeOptions());
    }

    /**
     * @return IframeOptions | EntityOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
