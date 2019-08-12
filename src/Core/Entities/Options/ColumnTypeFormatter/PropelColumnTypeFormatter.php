<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 21/10/2017
 * Time: 23:29
 */

namespace Core\Entities\Options\ColumnTypeFormatter;


use Core\Handlers\HandlerInterface;
use Propel\Generator\Model\PropelTypes;

class PropelColumnTypeFormatter implements ColumnTypeFormatterInterface
{

    /**
     * @param $bddType string
     * @return string
     */
    public function getBddTypeFormatted($bddType)
    {
        switch ($bddType){
            case PropelTypes::LONGVARCHAR:
                $type = HandlerInterface::TYPE_TEXTAREA;
                break;
            case PropelTypes::ENUM:
                $type = HandlerInterface::TYPE_SELECT;
                break;
            case PropelTypes::BOOLEAN:
                $type = HandlerInterface::TYPE_CHECKBOX;
                break;
            case PropelTypes::TIMESTAMP:
                $type = HandlerInterface::TYPE_DATETIME;
                break;
            case PropelTypes::DATE:
                $type = HandlerInterface::TYPE_DATE;
                break;
            case PropelTypes::TIME:
                $type = HandlerInterface::TYPE_TIME;
                break;
            case "image":
            case "file":
                $type = $bddType;
                break;
            default:
                $type = HandlerInterface::TYPE_TEXT;
                break;
        }

        return $type;
    }
}
