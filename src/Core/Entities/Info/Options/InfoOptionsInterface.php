<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/04/2019
 * Time: 10:21
 */

namespace Core\Entities\Info\Options;


interface InfoOptionsInterface
{
    /**
     * @param string $title
     * @return string
     */
    public function setTitle(string $title);

    /**
     * @param string $description
     */
    public function setDescription(string $description);

    /**
     * @param string $imagePath
     * @return $this
     */
    function setImagePath(string $imagePath);

}
