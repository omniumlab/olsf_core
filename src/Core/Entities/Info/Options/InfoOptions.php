<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/04/2019
 * Time: 10:21
 */

namespace Core\Entities\Info\Options;


use Core\Entities\Options\EntityOptions;

class InfoOptions extends EntityOptions implements InfoOptionsInterface
{


    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->setVariable("title", $title);
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->setVariable("description", $description);
    }

    function setImagePath(string $imagePath)
    {
        $this->setVariable("imagePath", $imagePath);
    }
}
