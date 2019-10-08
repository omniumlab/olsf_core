<?php


namespace Core\Entities\Change\FileManager\UploadFile;


use Core\Entities\EntityTypeBase;

class UploadFileType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_upload");
    }
}
