<?php


namespace Core\Entities\Change\FileManager\Rename;


use Core\Entities\EntityTypeBase;

class RenameType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_rename");
    }
}
