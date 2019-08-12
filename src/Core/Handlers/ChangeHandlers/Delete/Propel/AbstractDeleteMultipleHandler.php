<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2018
 * Time: 13:05
 */

namespace Core\Handlers\ChangeHandlers\Delete\Propel;


use Core\Commands\CommandInterface;
use Core\Handlers\ChangeHandlers\Delete\DeleteMultipleHandlerInterface;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;

abstract class AbstractDeleteMultipleHandler extends AbstractDeleteHandler implements DeleteMultipleHandlerInterface
{

    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandler)
    {
        parent::__construct($query, $textHandler,false);
    }

    public function getIds($ids)
    {
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        return $ids;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $ids = $command->get("ids", "", true);

        foreach ($this->getIds($ids) as $id) {
            $command->setUrlAttribute("id", $id);
            parent::handle($command);
        }

        return new SuccessHandlerResponse(200, [], $this->getTextHandler()->get("success_delete_handler_response_text" ));
    }
}
