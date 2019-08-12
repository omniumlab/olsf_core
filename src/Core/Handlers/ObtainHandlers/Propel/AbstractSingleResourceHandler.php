<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/04/2018
 * Time: 21:08
 */

namespace Core\Handlers\ObtainHandlers\Propel;


use Core\Exceptions\NotFoundException;
use Core\Handlers\ObtainHandlers\SingleResourceHandlerInterface;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;

abstract class AbstractSingleResourceHandler extends AbstractQueryHandler implements SingleResourceHandlerInterface
{
    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandle)
    {
        parent::__construct($query, $textHandle, true);
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        if ($command->getUrlIdParameter() === null) {
            throw new NotFoundException();
        }

        $dataObject = $this->getByPrimary($command->getUrlIdParameter());

        if ($dataObject === null) {
            throw new NotFoundException();
        }

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $dataObject->toArray());
    }
}