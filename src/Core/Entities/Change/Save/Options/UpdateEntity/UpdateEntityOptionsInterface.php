<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/08/2018
 * Time: 11:47
 */

namespace Core\Entities\Change\Save\Options\UpdateEntity;


use Core\Entities\Change\Save\Options\SaveButton;
use Core\Entities\Change\Save\Options\SaveEntityOptionsInterface;

interface UpdateEntityOptionsInterface extends SaveEntityOptionsInterface
{
    /**
     * @param string $singleResourceName
     */
    function setSingleResourceEntityName($singleResourceName);

    /**
     * @param SaveButton $saveButton
     * @return $this
     */
    public function setSaveButton(SaveButton $saveButton);
}
