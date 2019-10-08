<?php


namespace Core\Entities\Obtain\FileManager\Download;


use Core\Entities\EntityTypeBase;

class DownloadType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_download");
    }
}
