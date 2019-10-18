<?php


namespace Core\Entities\Obtain\FileManager\Options;


interface FileManagerEntityOptionsInterface
{
    /*
         * entity_create_folder: string
         * entity_upload_file: string
         * entity_move_to: string
     *     entity_rename: string
     *     entity_delete: string
     *     entity_zip: string
     *     entity_download: string
     *     entity_viewer: string
         */


    function setEntityCreateFolder(string $entityName): FileManagerEntityOptionsInterface;

    function setEntityUploadFile(string $entityName): FileManagerEntityOptionsInterface;

    function setEntityMoveTo(string $entityName): FileManagerEntityOptionsInterface;

    function setEntityRename(string $entityName): FileManagerEntityOptionsInterface;

    function setEntityDelete(string $entityName): FileManagerEntityOptionsInterface;

    function setEntityZip(string $entityName): FileManagerEntityOptionsInterface;

    function setEntityDownload(string $entityName): FileManagerEntityOptionsInterface;

    /**
     * @param string $entityName nombre de una entidad de tipo iframe
     * @return FileManagerEntityOptionsInterface
     */
    function setEntityViewer(string $entityName): FileManagerEntityOptionsInterface;
}
