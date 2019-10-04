<?php


namespace Core\Handlers\ChangeHandlers\Inbox;


use App\Propel\EmailRecipient;
use App\Propel\EmailSent;
use Core\Auth\AuthServiceInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractComposeHandler extends Handler
{
    /**
     * @var AuthServiceInterface
     */
    private $authService;

    public function __construct(TextHandlerInterface $textHandler, AuthServiceInterface $authService)
    {
        parent::__construct("POST", false, $textHandler);
        $this->authService = $authService;
    }

    public function handle($command): HandlerResponseInterface
    {
        $idEmail = $this->createEmail($command);
        $this->createRecipients($command, $idEmail);

        return new SuccessHandlerResponse(HttpCodes::CODE_OK);
    }

    private function createEmail(\Core\Commands\CommandInterface $command): int
    {
        $idFrom = $this->authService->getCurrentConnectedUser()->getId();
        $subject = $command->get("subject", null, true);
        $body = $command->get("body", null, true);

        $email = (new EmailSent())
            ->setIdFrom($idFrom)
            ->setSubject($subject)
            ->setBody($body);
        $email->save();

        return $email->getId();
    }

    private function createRecipients(\Core\Commands\CommandInterface $command, int $idEmail)
    {
        $userIds = explode(",", $command->get("user_ids", null, true));
        $notVisible = explode(",", $command->get("not_visible_user_ids", ""));

        foreach ($userIds as $idUser){
            $visible = !in_array($idUser, $notVisible);

            (new EmailRecipient())
                ->setIdEmailSent($idEmail)
                ->setIdUser($idUser)
                ->setVisible($visible)
                ->save();
        }
    }
}
