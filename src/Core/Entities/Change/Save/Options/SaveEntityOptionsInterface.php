<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 26/10/17
 * Time: 10:24
 */

namespace Core\Entities\Change\Save\Options;


use Core\Entities\Options\EntityOptionsInterface;

interface SaveEntityOptionsInterface extends EntityOptionsInterface
{
    const BUTTON_VISIBILITY_BOTH = 0;
    const BUTTON_VISIBILITY_SAVE = 1;
    const BUTTON_VISIBILITY_SAVE_AND_EXIT = 2;

    /**
     * @param SaveButton $saveButton
     * @return $this
     */
    public function setSaveButton(SaveButton $saveButton);

    public function setButtonsVisibility(int $visibility);
}
