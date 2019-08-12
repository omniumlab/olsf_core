<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 02/05/2019
 * Time: 9:29
 */

namespace Core\Entities\Upload;


use Core\Entities\EntityTypeBase;

class UploadType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("upload");
    }
}
