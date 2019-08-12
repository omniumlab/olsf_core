<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 04/04/2018
 * Time: 19:30
 */

namespace Core\Handlers\ObtainHandlers\Propel;


use Core\Exceptions\NotFoundException;
use Core\Handlers\ObtainHandlers\DetailHandlerInterface;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;

abstract class AbstractDetailHandler extends AbstractQueryHandler implements DetailHandlerInterface
{
    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandle)
    {
        parent::__construct($query, $textHandle, true);
    }

    /**
     * @return QueryHandlerInterface[]
     */
    public abstract function getChildQueryHandlers(): array;

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return HandlerResponseInterface
     * @throws \Core\Exceptions\NotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $id = $command->getUrlIdParameter();

        if ($id === null) {
            throw new NotFoundException();
        }

        if ($this->getParentField() !== null) {
            $this->setIdParent($id);
        }

        $object = $this->getByPrimary($id);
        $result = [];

        if ($object !== null) {
            $result[] = $object->toArray();
        }

        $result = array_merge($result, $this->getChildrenResult($id));

        if (!$result) {
            throw new NotFoundException();
        }

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, ["rows" => $result]);
    }

    private function getChildrenResult($id)
    {
        $childQueryHandlers = $this->getChildQueryHandlers();

        $result = [];

        foreach ($childQueryHandlers as $childQueryHandler) {
            $childQueryHandler->setIdParent($id);

            $childQueryHandler->doListQuery(null);

            while (($item = $childQueryHandler->next()) !== null) {
                $result[] = $item->toArray();
            }
        }

        return $result;
    }

    protected function translateAlias(bool $force = false)
    {
        foreach ($this->getFields() as &$field)
        {
            if (!$force && $field->getAlias() === $field->getName())
                $field->setAlias($this->getTextHandler()->get($field->getName()));
        }
    }
}
