<?php
/**
 * Created by PhpStorm.
 * User: Cristina
 * Date: 07/03/2019
 * Time: 19:20
 */

namespace Core\Encryptor;


use App\Config\AppGlobalConfigInterface;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Exception;

class Encryptor implements EncryptorInterface
{

    /** @var Key  */
    private $key;

    function __construct(AppGlobalConfigInterface $appGlobalConfig)
    {
        $this->key = Key::loadFromAsciiSafeString($appGlobalConfig->getEncriptorKey());
    }

    function encrypt(string $object): string
    {
        return Crypto::encrypt($object, $this->key);
    }

    function decrypt(string $object): string
    {
        try {
            return Crypto::decrypt($object, $this->key);
        } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex){
            throw new Exception("Unable to decrypt");
        }
    }

    function decryptFromIndex(string $object, $index)
    {
        $string = $this->decrypt($object);
        $sufix = substr($string, $index);
        $numOcultedChars = strlen($string) - strlen($sufix);

        return str_repeat("*", $numOcultedChars) . $sufix;
    }
}
