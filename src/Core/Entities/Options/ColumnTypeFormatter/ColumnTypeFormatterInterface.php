<?php
namespace Core\Entities\Options\ColumnTypeFormatter;

interface ColumnTypeFormatterInterface
{
    /**
     * @param $bddType string
     * @return string
     */
    public function getBddTypeFormatted($bddType);
}