<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 18:31
 */

namespace Core\Handlers\LoginHandler;


use Core\Exceptions\NotFoundException;
use Core\Handlers\Handler;
use Core\Mailer\MailerServiceInterface;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Templating\TemplateEngineInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractLostPasswordHandler extends Handler
{
    /**
     * @var \Core\Mailer\MailerServiceInterface
     */
    private $mailer;
    /**
     * @var \Core\Auth\User\UserProviderInterface
     */
    private $userProvider;
    /**
     * @var \Core\Templating\TemplateEngineInterface
     */
    private $templateEngine;
    /**
     * @var \Core\Handlers\LoginHandler\RecoverPasswordHandlerInterface
     */
    private $recoverPasswordHandler;

    /**
     * @var string
     */
    private $emailTemplateFileName = 'emails/recover.password.html.twig';



    /** @var  array */
    private $templateParameters = [];

    /**
     * AbstractLostPasswordHandler constructor.
     *
     * @param \Core\Mailer\MailerServiceInterface $mailer
     * @param \Core\Templating\TemplateEngineInterface $templateEngine
     * @param \Core\Text\TextHandlerInterface $textHandler
     * @param \Core\Handlers\LoginHandler\RecoverPasswordHandlerInterface $recoverPasswordHandler
     *
     */
    public function __construct(MailerServiceInterface $mailer, TemplateEngineInterface $templateEngine,
                                TextHandlerInterface $textHandler,
                                RecoverPasswordHandlerInterface $recoverPasswordHandler)
    {
        parent::__construct("POST", false, $textHandler);

        $this->mailer = $mailer;
        $this->userProvider = $recoverPasswordHandler->getUserProvider();
        $this->templateEngine = $templateEngine;
        $this->recoverPasswordHandler = $recoverPasswordHandler;

        $this->getPermission()->setNotRevocable();
    }

    protected function setEmailTemplateFileName(string $fileName)
    {
        $this->emailTemplateFileName = $fileName;
    }

    protected function setTemplateParameters(array $parameters)
    {
        $this->templateParameters = $parameters;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\InputRequiredException
     * @throws \Core\Exceptions\NotFoundException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $email = $command->getString("email", '', true);
        $user = $this->userProvider->getUserByEmail($email);

        if ($user === null) {
            throw new NotFoundException($this->getTextHandler()->get("failure_recoverpass_response"), 400);
        }

        $url = $this->recoverPasswordHandler->getFullUrl($user);
        $subject = $this->getTextHandler()->get("recover_password_subject");
        $this->templateParameters["url"] = $url;

        $body = $this->templateEngine->render($this->emailTemplateFileName, $this->templateParameters);

        $this->mailer->createMail()
            ->setSubject($subject)
            ->addTo($email)
            ->setBody($body)
            ->setAsHtml()
            ->send();

        return new SuccessHandlerResponse(200, [], $this->getTextHandler()->get("recoverpass_success_response"));
    }

    ///**
    // * LoginBaseController constructor.
    // *
    // * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
    // */
    //public function __construct(ContainerInterface $container)
    //{
    //    $this->container = $container;
    //}
    //
    ///**
    // * @param Request $request
    // * @param \Swift_Mailer $mailer
    // *
    // * @return \OLSF\RestBundle\Request\Response\Json\RestResponseBase
    // * @Post("/reset_password");
    // *
    // */
    //public function resetPassword(Request $request, \Swift_Mailer $mailer)
    //{
    //    $username = $request->request->get("username");
    //
    //    $query = $this->getUserProvider();
    //
    //    try {
    //        $user = $query->loadUserByUsername($username);
    //    } catch (UsernameNotFoundException $ex) {
    //        return new RestErrorResponse(400, [], $ex->getMessage());
    //    }
    //
    //    if (!$user->getLostPasswordToken()) {
    //        $user->createLostPasswordToken();
    //    }
    //
    //    $fromEmail = $this->container->getParameter("mailer_from_email");
    //    $fromName = $this->container->getParameter("mailer_from_name");
    //
    //    $message = (new \Swift_Message('Recover password'))
    //        ->setFrom($fromEmail, $fromName)
    //        ->setTo($user->getEmail())
    //        ->setBody(
    //            $this->getLostPasswordBodyEmail($user, $request),
    //            'text/html'
    //        );
    //
    //    $mailer->send($message);
    //
    //    return new RestSuccessResponse(200, [], "An email has been sent to restore your password");
    //}
    //
    //protected function getLostPasswordBodyEmail(AuthUserInterface $user, Request $request)
    //{
    //    return $this->renderView(
    //        '@OLSFLogin/Emails/lost_password.html.twig',
    //        ["link" => $this->getLinkEmailRecover($user, $request)]
    //    );
    //}
    //
    ///**
    // * @param $idUser
    // * @param $token
    // *
    // * @return \OLSF\RestBundle\Request\Response\Json\RestResponseBase
    // * @Get("/reset_password/{idUser}/{token}")
    // *
    // */
    //public function checkLostPasswordToken($idUser, $token)
    //{
    //    $query = $this->getUserProvider();
    //
    //    $user = $query->loadUserById($idUser);
    //
    //    if ($user->getLostPasswordToken() == $token) {
    //        return new RestSuccessResponse(200);
    //    } else {
    //        return new RestErrorResponse(400, [], "This link is not correct or is already used");
    //    }
    //}
    //
    ///**
    // * @param \Symfony\Component\HttpFoundation\Request $request
    // * @param int $idUser
    // * @param string $token
    // *
    // * @return \OLSF\RestBundle\Request\Response\Json\RestResponseBase
    // * @Route("/reset_password/{idUser}/{token}")
    // * @Method({"POST"})
    // *
    // */
    //public function changePasswordWithToken(Request $request, $idUser, $token)
    //{
    //    $query = $this->getUserProvider();
    //
    //    $user = $query->getUserById($idUser);
    //
    //    if ($user->getLostPasswordToken() != $token) {
    //        return new RestErrorResponse(400, [], "This link is not correct or is already used");
    //    }
    //
    //    $newPassword = $request->request->get("password");
    //
    //    if (strlen($newPassword) < 8) {
    //        return new RestErrorResponse(400, [], "The password must have at least 8 characters");
    //    }
    //
    //    $user->setPassword($newPassword);
    //    $user->save();
    //
    //    return new RestSuccessResponse(200, [], "Password changed");
    //}
    //
    ///**
    // * Gets the UserProvider used to find the user.
    // *
    // * @return \Auth\User\UserProviderInterface
    // */
    //abstract public function getUserProvider();
    //
    ///**
    // * Compose the link to be sent to the user email for recovering the password.
    // *
    // * @param \Auth\User\AuthUserInterface $user
    // * @param \Symfony\Component\HttpFoundation\Request $request
    // *
    // * @return mixed
    // */
    //abstract protected function getLinkEmailRecover(AuthUserInterface $user, Request $request);
}