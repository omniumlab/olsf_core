<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 24/07/2017
 * Time: 11:46
 */

namespace Core\Commands;


interface ListHandlerCommandInterface extends CommandInterface
{
    const DEFAULT_LIMIT = 10;

    /**
     * @return int Offset from wich you want to start (starting at 0)
     */
    public function getOffset();

    /**
     * @return int Number of rows to get in the query
     */
    public function getLimit();

    /**
     * @return array ["columnName", "ASC"|"DESC"]
     */
    public function getSort();

    /**
     * @return array [filterName => filter]
     */
    public function getFilters();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @return bool
     */
    public function autocomplete();

    /**
     * @return string
     */
    public function getAutocomplete();
}