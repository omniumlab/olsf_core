<?php


namespace Core\Handlers\ChangeHandlers\Inbox;


use App\Propel\EmailRecipient;
use App\Propel\EmailSent;
use App\Propel\Map\UserTableMap;
use App\Propel\UserQuery;
use Core\Auth\AuthServiceInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\Criteria;

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
        $idParent = $command->get("id_parent");

        $email = (new EmailSent())
            ->setIdFrom($idFrom)
            ->setSubject($subject)
            ->setBody($body)
            ->setIdParent($idParent);
        $email->save();

        return $email->getId();
    }

    private function createRecipients(\Core\Commands\CommandInterface $command, int $idEmail)
    {
        $emails = explode(",", $command->get("emails", null, true));
        $notVisible = explode(",", $command->get("not_visible_emails", ""));

        $users = UserQuery::create()
            ->filterByEmail($emails, Criteria::IN)
            ->select([UserTableMap::COL_ID, UserTableMap::COL_EMAIL])
            ->find()->getData();

        foreach ($users as $user){
            $id = $user[UserTableMap::COL_ID];
            $email = $user[UserTableMap::COL_EMAIL];

            $visible = !in_array($email, $notVisible);

            (new EmailRecipient())
                ->setIdEmailSent($idEmail)
                ->setIdUser($id)
                ->setVisible($visible)
                ->save();
        }
    }
}
