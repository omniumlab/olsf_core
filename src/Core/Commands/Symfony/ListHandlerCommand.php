<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 12/06/2018
 * Time: 18:24
 */

namespace Core\Commands\Symfony;


use Core\Commands\AbstractCommand;
use Core\Commands\CommandInterface;
use Core\Commands\ListHandlerCommandInterface;

class ListHandlerCommand extends AbstractCommand implements ListHandlerCommandInterface
{
    public function __construct(CommandInterface $command)
    {
        parent::__construct($command->all(), $command->getAllUrlAttributes(), $command->getHttpVerb(),
                            $command->getHeaders());
    }

    /**
     * @return int Offset from wich you want to start (starting at 0)
     * @throws \Core\Exceptions\InputFormatException
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function getOffset()
    {
        return $this->getInt("offset", 0);
    }

    /**
     * @return int Number of rows to get in the query
     * @throws \Core\Exceptions\InputRequiredException
     * @throws \Core\Exceptions\InputFormatException
     */
    public function getLimit()
    {
        return $this->getInt("limit", ListHandlerCommandInterface::DEFAULT_LIMIT);
    }

    public function setLimit($limit)
    {
        $this->add(["limit" => $limit]);
    }

    /**
     * @return array ["columnName", "ASC"|"DESC"]
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function getSort()
    {
        $requestValue = $this->getString("sort", null);
        $sort = [];

        if (!empty($requestValue)) {
            $requestValue = str_replace("__", ".", $requestValue);

            $firstUnderscorePosition = strpos($requestValue, "_");

            $sort[] = substr($requestValue, $firstUnderscorePosition + 1);
            $sort[] = strtoupper(substr($requestValue, 0, $firstUnderscorePosition));

        }

        return $sort;
    }


    /**
     * @return array [filterName => filter]
     */
    public function getFilters()
    {
        $queryParameters = $this->all();//$this->parse_qs($_SERVER['QUERY_STRING']);
        $filters = [];

        foreach ($queryParameters as $key => $value) {
            if (strpos($key, "filter_in_") !== false) {
                $columnName = str_replace("__", ".", substr($key, 10));

                $filters[$columnName] = explode(",", $value);
            } else if (strpos($key, "filter_") !== false) {
                $columnName = str_replace("__", ".", substr($key, 7));

                $filters += [$columnName => $value];
            }
        }

        return $filters;
    }

    /**
     * @return bool
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function autocomplete()
    {
        return !!$this->get("autocomplete", false);
    }

    /**
     * @return string
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function getAutocomplete()
    {
        return $this->getString("autocomplete", null);
    }


    /**
     * @return string
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function getLocale()
    {
        return $this->getString("locale", "en");
    }
}