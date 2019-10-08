<?php


namespace Core\Entities\Change\FileManager\Delete;


use Core\Entities\EntityTypeBase;

class DeleteType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_delete");
    }
}
