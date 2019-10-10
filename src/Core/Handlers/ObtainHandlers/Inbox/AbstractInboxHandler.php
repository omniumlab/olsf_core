<?php


namespace Core\Handlers\ObtainHandlers\Inbox;


use App\Propel\EmailRecipientQuery;
use App\Propel\EmailSentQuery;
use App\Propel\Map\EmailRecipientTableMap;
use App\Propel\Map\EmailSentTableMap;
use App\Propel\Map\UserTableMap;
use App\Propel\UserQuery;
use Core\Auth\AuthServiceInterface;
use Core\Fields\Output\FunctionField;
use Core\Fields\Output\Text;
use Core\Handlers\ObtainHandlers\Propel\ListHandler\AbstractListHandler;
use Core\Output\HttpCodes;
use Core\Output\OutputObjectInterface;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;

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


    public function handle($command): HandlerResponseInterface
    {
        $idUser = $this->authService->getCurrentConnectedUser()->getId();
        $offset= $command->get("offset", 0);
        $limit = $command->get("limit", 10);
        $sent = $command->get("sent", "0") == 1;
        $joinEmailRecipient = "INNER JOIN " . EmailRecipientTableMap::TABLE_NAME . " ON (email.id=" . EmailRecipientTableMap::COL_ID_EMAIL_SENT . ")";

        $sql = "SELECT email.id AS 'id', user.name AS 'from_name', user.email AS 'from_email',
 email.subject AS 'subject', email.body AS 'body', email.date AS 'date', email.id_parent AS 'id_parent'

        FROM email_sent as email

        INNER JOIN user ON (email.id_from=user.id) " .

        ($sent ? "" : $joinEmailRecipient) .

         " WHERE email.id IN (
            SELECT MAX(id) as id
            FROM email_sent 
            GROUP BY IFNULL(id_parent, email_sent.id)
            ORDER BY email_sent.date DESC ) AND " .

            ($sent ? "email.id_from=?" : EmailRecipientTableMap::COL_ID_USER . "=?") .

        " ORDER BY date DESC LIMIT " . $limit . " OFFSET ". $offset;

        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $idUser);
        $stmt->execute();
        $data = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $up) {
            $data[] = $up;
        }

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $data);
    }

    public function postNext(OutputObjectInterface $row)
    {
        $text = $row->getValue("body");
        $text = strlen($text) > 98 ? substr($text, 0, 98) . "..." : $text;
        $row->addRawDataValue("body", $text);
    }
}
