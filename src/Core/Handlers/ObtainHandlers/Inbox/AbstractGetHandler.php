<?php


namespace Core\Handlers\ObtainHandlers\Inbox;


use App\Propel\EmailRecipientQuery;
use App\Propel\EmailSent;
use App\Propel\EmailSentQuery;
use App\Propel\Map\EmailRecipientTableMap;
use App\Propel\Map\UserTableMap;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\Criteria;

abstract class AbstractGetHandler extends Handler
{
    public function __construct(TextHandlerInterface $textHandler)
    {
        parent::__construct("GET", true, $textHandler);
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function handle($command): HandlerResponseInterface
    {
        $email = EmailSentQuery::create()
            ->joinUser()
            ->findOneById($command->getUrlIdParameter());

        $recipients = $this->getRecipients($email->getId());
        $response = $this->getArrayFromEmail($email);
        $response["recipients"] = $recipients;
        $response["parents"] = $this->getParents($email->getId(), $email->getIdParent());

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $response);
    }

    private function getRecipients(int $id): array
    {
        $emails = EmailRecipientQuery::create()
            ->joinUser()
            ->filterByIdEmailSent($id, Criteria::EQUAL)
            ->select([UserTableMap::COL_EMAIL])
            ->find()->getData();


        $data = [];
        foreach ($emails as $email) {
            $data[] = $email;
        }

        return $data;
    }

    private function getParents(int $id, int $idParent): array
    {
        $emails = EmailSentQuery::create()
            ->filterByIdParent($idParent, Criteria::EQUAL)
            ->filterById($id, Criteria::NOT_EQUAL)
            ->orderByDate(Criteria::DESC)
            ->find()->getData();

        $parents = [];
        foreach ($emails as $email)
            $parents[] = $this->getArrayFromEmail($email);

        return $parents;
    }

    private function getArrayFromEmail(EmailSent $email): array
    {
        return [
            "id" => $email->getId(),
            "from_name" => $email->getUser()->getName(),
            "from_email" => $email->getUser()->getEmail(),
            "subject" => $email->getSubject(),
            "body" => $email->getBody(),
            "date" => $email->getDate("d-m-Y H:i:s"),
        ];
    }
}
