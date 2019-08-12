<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/04/2019
 * Time: 10:13
 */

namespace Core\Entities\Info;


use Core\Entities\AbstractEntity;
use Core\Entities\Virtual\VirtualEntity;
use Core\Entities\Info\Options\InfoOptions;
use Core\Entities\Info\Options\InfoOptionsInterface;
use Core\Handlers\WelcomeHandler\AbstractWelcomeHandler;
use Core\Text\TextHandlerInterface;

class InfoEntity extends VirtualEntity
{
    function __construct(TextHandlerInterface $textHandler)
    {
        parent::__construct(new InfoType(), $textHandler);
        $this->setOptions(new InfoOptions());
        $this->getPermission()->setNotRevocable();
        $this->setUrl("info");
        $this->getOptions()->setImagePath("images/panel/welcome.png");
    }

    /**
     * @return \Core\Entities\Options\EntityOptionsInterface|InfoOptions|InfoOptionsInterface
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
