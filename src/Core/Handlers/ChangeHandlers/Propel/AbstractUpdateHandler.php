<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 31/07/2017
 * Time: 10:29
 */

namespace Core\Handlers\ChangeHandlers\Propel;


use Core\Commands\CommandInterface;
use Core\Fields\Input\InputFieldInterface;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Propel;

abstract class AbstractUpdateHandler extends AbstractExistingDataHandler
{

    public function __construct(ModelCriteria $query,
                                TextHandlerInterface $textHandler, $individual = true)
    {
        parent::__construct($query, "PUT", $individual, $textHandler);
    }

    public function setup()
    {
        $this->getFields();
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\InputRequiredException
     * @throws \Core\Exceptions\NotFoundException
     * @throws \ReflectionException
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();

        $object = $this->getByPrimary($command->getUrlIdParameter());
        $this->fillObject($command, $object, false);
        $this->saveImages($command, $object, $command->getUrlIdParameter());

        $object->save();
        $this->postUpdate([$command->getUrlIdParameter()], []);

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [], $this->getTextHandler()->get("update_success_response"));
    }

    /**
     * @param $ids
     * @param array $values
     *
     * @return int
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateByIds($ids, $values)
    {
        $tableMap = $this->query->getTableMap();
        $primaryKeys = $tableMap->getPrimaryKeys();
        $primary = reset($primaryKeys)->getPhpName();
        $this->query->filterBy($primary, $ids, Criteria::IN);

        return $this->update($values);
    }

    /**
     * @param $values
     *
     * @return int
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update($values)
    {
        $tableMap = $this->query->getTableMap();
        $phpValues = [];

        foreach ($values as $column => &$value) {
            // TODO sustituir esto y anotarlo en la doc cuando encajemos su uso en el nuevo sistema
            //if ($column === $this->getUserIdField() && $this->isRestrictedUser()) {
            //    $value = $this->getRestrictedUserId();
            //}

            $phpValues[$tableMap->getColumn($column)->getPhpName()] = $value;
        }

        $this->addConditions();

        $response = $this->query->update($phpValues);
        $this->postUpdate([], $values);

        return $response;
    }

    /**
     * @param $idsToUpdate array
     * @param $values
     */
    public function postUpdate($idsToUpdate, $values)
    {

    }

    public function replaceInto($ids, $values)
    {
        $tableMap = $this->query->getTableMap();
        $primaryKeys = $tableMap->getPrimaryKeys();
        $primary = reset($primaryKeys)->getFullyQualifiedName();

        $fields = [$primary];

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $con = Propel::getConnection($tableMap::DATABASE_NAME);
        $fields = array_merge($fields, array_keys($values));
        $fields = implode(",", $fields);

        $sqlValues = array_fill(0, count($ids), "( ?," . str_repeat("?", count($values)) . ")");
        $sqlValues = implode(",", $sqlValues);

        $statement = $con->prepare("REPLACE INTO " . $tableMap->getName() . "(" . $fields . ") VALUES " . $sqlValues);
        $values = array_values($values);

        $pkPos = 1;
        /** @var array $ids */
        foreach ($ids as $index => $id) {
            $statement->bindValue($pkPos, $id);
            foreach ($values as $valueIndex => $value) {
                $statement->bindValue($pkPos + $valueIndex + 1, $value);
            }
            $pkPos += 1 + count($values);
        }

        $statement->execute();
    }

    /**
     * @param \Core\Fields\Input\InputFieldInterface $field
     *
     * @return mixed
     * @throws \Exception
     */
    public function findValue(InputFieldInterface $field, CommandInterface $command)
    {
        if (!$command->has(str_replace(".", "__", $field->getInputKeyName()))) {
            throw new \Exception("This Field is not passed in Request");
        }

        return $field->findValue($command);
    }
}