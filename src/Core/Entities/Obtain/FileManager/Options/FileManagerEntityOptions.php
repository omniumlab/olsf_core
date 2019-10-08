<?php


namespace Core\Entities\Obtain\FileManager\Options;


use Core\Entities\Options\EntityOptions;

class FileManagerEntityOptions extends EntityOptions implements FileManagerEntityOptionsInterface
{

    function setEntityCreateFolder(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_create_folder", $entityName);
        return $this;
    }

    function setEntityUploadFile(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_upload_file", $entityName);
        return $this;
    }

    function setEntityMoveTo(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_move_to", $entityName);
        return $this;
    }

    function setEntityRename(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_rename", $entityName);
        return $this;
    }

    function setEntityDelete(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_delete", $entityName);
        return $this;
    }

    function setEntityZip(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_zip", $entityName);
        return $this;
    }

    function setEntityDownload(string $entityName): FileManagerEntityOptionsInterface
    {
        $this->setVariable("entity_download", $entityName);
        return $this;
    }
}
