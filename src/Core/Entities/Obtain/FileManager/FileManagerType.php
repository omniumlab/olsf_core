<?php


namespace Core\Entities\Obtain\FileManager;


use Core\Entities\EntityTypeBase;

class FileManagerType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager");
    }
}
