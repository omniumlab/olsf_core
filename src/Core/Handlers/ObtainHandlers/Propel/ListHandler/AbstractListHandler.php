<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/04/2018
 * Time: 20:04
 */

namespace Core\Handlers\ObtainHandlers\Propel\ListHandler;


use Core\Commands\ListHandlerCommandInterface;
use Core\Commands\Symfony\ListHandlerCommand;
use Core\Handlers\ObtainHandlers\ListHandlerInterface;
use Core\Handlers\ObtainHandlers\Propel\AbstractQueryHandler;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;

abstract class AbstractListHandler extends AbstractQueryHandler implements ListHandlerInterface
{
    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandle)
    {
        parent::__construct($query, $textHandle);
    }


    /**
     * Method to get summations of this list
     *
     * @return \Core\Handlers\ObtainHandlers\Propel\ListHandler\Summatory[]
     */
    public function getSummaries(): array
    {
        return [];
    }

    /**
     * @param \Core\Commands\ListHandlerCommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        if (!($command instanceof ListHandlerCommandInterface)) {
            $command = new ListHandlerCommand($command);
        }

        if ($command->getUrlIdParameter() !== null) {
            $this->setIdParent($command->getUrlIdParameter());
        }

        $this->doListQuery($command);

        $data = $this->getData();

        $this->addSummaries($data);

        return new SuccessHandlerResponse(200, $data);
    }

    private function addSummaries(array &$data)
    {
        $summaries = $this->getSummaries();

        foreach ($summaries as $summary){
            $data["summary"][] = $summary->getValues();
        }
    }

    private function getData()
    {
        $result = [];

        while (($item = $this->next()) !== null) {
            $result[] = $item->toArray();
        }

        return [
            "total" => $this->getCount(),
            "rows" => $result,
        ];
    }
}