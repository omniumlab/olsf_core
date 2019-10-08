<?php


namespace Core\Entities\Change\FileManager\CreateFolder;


use Core\Entities\EntityTypeBase;

class CreateFolderType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_create_folder");
    }
}
