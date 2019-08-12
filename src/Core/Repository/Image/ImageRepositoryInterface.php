<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 01/10/2018
 * Time: 12:26
 */

namespace Core\Repository\Image;


interface ImageRepositoryInterface
{

    /**
     * @param string $resource
     * @param int $id
     * @param bool $private
     * @return string
     */
    function getUriDataFromResource(string $resource, int $id, bool $private = false): ?string;

    function getUriData(string $filePath): ?string;

    function saveImage(?string $imageName, string $filePath, string $base64, $id = null, $private = false);

    /**
     * @param int $minHeight
     */
    public function setMinHeight(int $minHeight);

    /**
     * @param int $minWidth
     */
    public function setMinWidth($minWidth);
}