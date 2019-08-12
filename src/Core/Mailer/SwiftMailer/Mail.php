<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 19/07/2018
 * Time: 16:32
 */

namespace Core\Mailer\SwiftMailer;


use Core\Mailer\MailInterface;

class Mail implements MailInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Swift_Message
     */
    private $mail;


    /**
     * Mail constructor.
     *
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->mail = new \Swift_Message();
    }

    public function setAsHtml(): MailInterface
    {
        $this->mail->setContentType("text/html");

        return $this;
    }

    public function addTo(string $address, string $name = ''): MailInterface
    {
        $this->mail->addTo($address, $name);

        return $this;
    }

    public function setFrom(string $from, ?string $name = null): MailInterface
    {
        $this->mail->setFrom($from, $name);

        return $this;
    }

    public function setSubject(string $subject): MailInterface
    {
        $this->mail->setSubject($subject);

        return $this;
    }

    public function setBody(string $body): MailInterface
    {
        $this->mail->setBody($body);

        return $this;
    }

    function attach(string $filePath, ?string $fileName = null)
    {
        $attachment = \Swift_Attachment::fromPath($filePath);
        $attachment->setDisposition("inline");
        if ($fileName !== null)
            $attachment->setFilename($fileName);
        $this->mail->attach($attachment);
    }

    public function send(): bool
    {
        return $this->mailer->send($this->mail);
    }
}
