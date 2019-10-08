<?php


namespace Core\Entities\Change\FileManager\Zip;


use Core\Entities\EntityTypeBase;

class ZipType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_type");
    }
}
