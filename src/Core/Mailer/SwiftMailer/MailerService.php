<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 19/07/2018
 * Time: 16:31
 */

namespace Core\Mailer\SwiftMailer;


use Core\Config\GlobalConfigInterface;
use Core\Mailer\MailerServiceInterface;
use Core\Mailer\MailInterface;

class MailerService implements MailerServiceInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /** @var GlobalConfigInterface */
    private $config;


    /**
     * MailerService constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param GlobalConfigInterface $config
     */
    public function __construct(\Swift_Mailer $mailer, GlobalConfigInterface $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

    public function createMail(): MailInterface
    {
        $mail = new Mail($this->mailer);
        $mail->setFrom($this->config->getMailerFromEmail(), $this->config->getMailerFromName());

        return $mail;
    }
}