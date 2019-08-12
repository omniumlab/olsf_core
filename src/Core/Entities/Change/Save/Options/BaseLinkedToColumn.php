<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 26/09/2018
 * Time: 16:42
 */

namespace Core\Entities\Change\Save\Options;


use Core\ListValue\BaseListValue;
use Core\ListValue\ListValueInterface;
use Core\ListValue\ValueInterface;

class BaseLinkedToColumn implements ValueInterface
{
    /**
     * @var ListValueInterface $variables Class variables
     * "local" string
     * "foreign" string
     */
    private $variables;

    /**
     * BaseLinkedToColumn constructor.
     * @param $local string
     * @param $foreign string
     */
    public function __construct($local, $foreign)
    {
        $this->variables = new BaseListValue();
        $this->setLocal($local);
        $this->setForeign($foreign);
    }

    /**
     * @param $local string
     */
    public function setLocal($local){
        $this->variables->setValue($local, "local");
    }

    /**
     * @param $foreign string
     */
    public function setForeign($foreign){
        $this->variables->setValue($foreign, "foreign");
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}