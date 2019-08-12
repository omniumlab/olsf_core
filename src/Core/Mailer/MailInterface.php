<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 18:41
 */

namespace Core\Mailer;


interface MailInterface
{
    public function setAsHtml(): MailInterface;

    public function addTo(string $address, string $name = ''): MailInterface;

    public function setSubject(string $subject): MailInterface;

    public function setBody(string $body): MailInterface;

    /**
     * @param string $filePath
     * @param string|null $fileName Nombre del archivo que se adjuntará al email. Si no se pasa ninguo, se utilizará el propio del archivo.
     */
    function attach(string $filePath, ?string $fileName = null);

    public function send(): bool;
}
