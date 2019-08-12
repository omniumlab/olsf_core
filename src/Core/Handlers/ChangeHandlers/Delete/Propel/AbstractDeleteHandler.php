<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 31/07/2017
 * Time: 18:35
 */

namespace Core\Handlers\ChangeHandlers\Delete\Propel;


use Core\Handlers\ChangeHandlers\Propel\AbstractExistingDataHandler;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Map\TableMap;

abstract class AbstractDeleteHandler extends AbstractExistingDataHandler
{

    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandler, $individual = true)
    {
        parent::__construct($query, "DELETE", $individual,$textHandler);
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\NotFoundException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $object = $this->getByPrimary($command->getUrlIdParameter());

        if ($this->query->getTableMap()->hasColumn("deleted_at")){
            $object->setDeletedAt(new \DateTime())->save();
        }else{
            $object->delete();
        }

        return new SuccessHandlerResponse(200, [], $this->getTextHandler()->get("success_delete_handler_response_text" ));
    }
}
