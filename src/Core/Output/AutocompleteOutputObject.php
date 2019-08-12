<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/11/2017
 * Time: 20:11
 */

namespace Core\Output;


use Core\Fields\Output\OutputFieldInterface;

class AutocompleteOutputObject extends BaseOutputObject
{
    /**
     * @param OutputFieldInterface[] $fields
     * @param array                  $rawData
     */
    public function __construct($fields = [], array $rawData = [])
    {
        parent::__construct($fields, $rawData);
    }

    public function toArray()
    {
        $id = null;
        $visualValues = [];

        foreach ($this->getFields() as $field)
        {
            $value = $this->getValue($field);

            if ($field->isPrimaryKey()) {
                //if ($id !== null)
//                    throw new \Exception("You cannot have more than 1 primary key when using foreign keys");

                if($id === null)
                    $id = $value;
            }
            else
                $visualValues[] = $value;
        }

        return ["id" => $id, "value" => trim(implode(" ",$visualValues))];
    }


}