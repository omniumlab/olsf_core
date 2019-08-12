<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/08/2018
 * Time: 11:46
 */

namespace Core\Entities\Change\Save\Options\UpdateEntity;


use Core\Entities\Change\Save\Options\SaveButton;
use Core\Entities\Change\Save\Options\SaveColumn;
use Core\Entities\Change\Save\Options\SaveEntityOptions;
use Core\Entities\ColumnableEntityOptionsInterface;

class UpdateEntityOptions extends SaveEntityOptions implements UpdateEntityOptionsInterface, ColumnableEntityOptionsInterface
{
    /*
     * "dynamicFieldsEntity" string
     */
    
    /**
     * @param string $singleResourceName
     */
    function setSingleResourceEntityName($singleResourceName)
    {
        $this->setVariable("singleResourceEntityName", $singleResourceName);
    }

    /**
     * @return SaveColumn[]
     */
    function getColumns(): array
    {
        return $this->getVariable("columns");
    }

    public function setSaveButton(SaveButton $saveButton)
    {
        $this->setVariable("saveButton", $saveButton);
        return $this;
    }

    function setDynamicFieldsEntity(string $entity)
    {
        $this->setVariable("dynamicFieldsEntity", $entity);
    }
}
