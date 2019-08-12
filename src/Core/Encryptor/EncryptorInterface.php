<?php
/**
 * Created by PhpStorm.
 * User: Cristina
 * Date: 07/03/2019
 * Time: 19:20
 */

namespace Core\Encryptor;


interface EncryptorInterface
{

    function encrypt(string $object): string;

    function decrypt(string $object): string;

    function decryptFromIndex(string $object, $index);
}
