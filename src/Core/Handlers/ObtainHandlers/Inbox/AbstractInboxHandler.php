<?php


namespace Core\Handlers\ObtainHandlers\Inbox;


use App\Propel\EmailRecipientQuery;
use App\Propel\EmailSentQuery;
use App\Propel\Map\EmailRecipientTableMap;
use App\Propel\Map\EmailSentTableMap;
use App\Propel\Map\UserTableMap;
use App\Propel\UserQuery;
use Core\Auth\AuthServiceInterface;
use Core\Fields\Output\Text;
use Core\Handlers\ObtainHandlers\Propel\ListHandler\AbstractListHandler;
use Core\Output\OutputObjectInterface;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\Criteria;

abstract class AbstractInboxHandler extends AbstractListHandler
{
    /**
     * @var AuthServiceInterface
     */
    private $authService;

    public function __construct(TextHandlerInterface $textHandle, AuthServiceInterface $authService)
    {
        parent::__construct(EmailSentQuery::create(), $textHandle);
        $this->authService = $authService;
    }

    public function setup()
    {
        $this->join(UserQuery::create(), EmailSentTableMap::COL_ID_FROM);

        $this->createField(EmailSentTableMap::COL_ID, "id");
        $this->createField(UserTableMap::COL_NAME, "from_name");
        $this->createField(UserTableMap::COL_EMAIL, "from_email");
        $this->createField(EmailSentTableMap::COL_SUBJECT, "subject");
        $this->createField(EmailSentTableMap::COL_BODY, "body");
        $this->createField(EmailSentTableMap::COL_DATE, "date");
    }

    public function handle($command): HandlerResponseInterface
    {
        $idUser = $this->authService->getCurrentConnectedUser()->getId();

        $sent = $command->get("sent");
        if ($sent === null || $sent !== "0"){
            $this->join(EmailRecipientQuery::create());
            $this->addAnd(EmailRecipientTableMap::COL_ID_USER, Criteria::EQUAL, $idUser);
        }else{
            $this->addAnd(EmailSentTableMap::COL_ID_FROM, Criteria::EQUAL, $idUser);
        }

        $response = parent::handle($command);
        $data = $response->getData();

        $this->addRecipients($data["rows"]);

        $response->setData($data);

        return $response;
    }

    private function addRecipients(array &$rows)
    {
        $emailIds = array_column($rows, "id");
        $emails = EmailRecipientQuery::create()
            ->joinUser()
            ->filterByIdEmailSent($emailIds, Criteria::IN)
            ->select([EmailRecipientTableMap::COL_ID_EMAIL_SENT, UserTableMap::COL_EMAIL])
            ->find()->getData();


        $data = [];
        foreach ($emails as $email){
            $idEmail = $email[EmailRecipientTableMap::COL_ID_EMAIL_SENT];
            $data[$idEmail][] = $email[UserTableMap::COL_EMAIL];
        }
        foreach ($rows as &$row){
            $idEmail = $row["id"];
            $row["recipients"] = array_key_exists($idEmail, $data) ? $data[$idEmail] : [];
        }
    }

    public function postNext(OutputObjectInterface $row)
    {
        $text = $row->getValue("body");
        $text = strlen($text) > 98 ? substr($text, 0, 98) . "..." : $text;
        $row->addRawDataValue("body", $text);
    }
}
