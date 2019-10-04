<?php


namespace Core\Handlers\ObtainHandlers\Inbox;


use App\Propel\EmailSentQuery;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

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

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [
            "id" => $email->getId(),
            "from_name" => $email->getUser()->getName(),
            "from_email" => $email->getUser()->getEmail(),
            "subject" => $email->getSubject(),
            "body" => $email->getBody(),
            "date" => $email->getDate("d-m-Y H:i:s")
        ]);
    }
}
