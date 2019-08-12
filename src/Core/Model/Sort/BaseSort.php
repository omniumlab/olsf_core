<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 30/01/2018
 * Time: 13:22
 */

namespace Core\Model\Sort;


class BaseSort
{

    /**
     * @param $models Sortable[]
     * @param $sorts integer[]
     * @param $actualIndex
     * @param $posDes integer Destination position
     */
    public static function changeSortCorrelatively($models, $sorts, $actualIndex, $posDes){
        $posDes = (integer)$posDes;
        $isPositionOccupied = in_array($posDes, $sorts);
        $isSamePosition = $posDes === $sorts[$actualIndex];

        if (sizeof($sorts) >= $posDes - 1 && !$isSamePosition && $posDes !== 0 && $isPositionOccupied){
            $nextIndex = array_search($posDes, $sorts);
            $sorts[$actualIndex] = $posDes;
            BaseSort::changeSortCorrelatively($models, $sorts, $nextIndex, $posDes + 1);
        }

        $models[$actualIndex]->setSort($posDes, false)->save();
    }
}