<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 06/05/2019
 * Time: 10:26
 */

namespace Core\Entities\Change\Save\Options;


use Core\ListValue\BaseListValue;
use Core\ListValue\ValueInterface;

class SaveButton implements ValueInterface
{

    /**
     * @var BaseListValue
     *
     * "name" string
     * "style" string|null
     */
    private $variables;

    public function __construct()
    {
        $this->variables = new BaseListValue();
    }

    public function setName(string $name)
    {
        $this->variables->setValue($name, "name");
        return $this;
    }

    public function setStyle(?string $style)
    {
        $this->variables->setValue($style, "style");
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->variables->getValues();
    }
}
