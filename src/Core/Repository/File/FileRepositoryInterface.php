<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 16/04/2019
 * Time: 16:06
 */

namespace Core\Repository\File;


use Core\Commands\CommandInterface;

interface FileRepositoryInterface
{
    function saveInResource(string $base64, string $folderName, string $fileName);

    function save(string $base64, string $path);

    /**
     * @param string $folder Nombre de la carpeta donde se buscará los archivos dentro de la carpeta "files".
     * @param int|null $offset
     * @param int|null $limit
     * @param string[] $extensions Filtro de extensiones para que solo busque las seleccionadas
     * @param string|null $nameFilter Nombre para filtrar
     * @param bool $withDirControl
     * @return string[]
     */
    function getFiles(string $folder, ?int $offset = 0, ?int $limit = 0, array $extensions = [], ?string $nameFilter = null, bool $withDirControl = false): array;

    function deleteFile(string $path);

    function uploadResourceByCommand(CommandInterface $command, string $folderName,  ?int $id = null, ?string $fileName = null);
}
