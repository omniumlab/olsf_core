<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 19/05/2018
 * Time: 12:55
 */

namespace Core\Fields\Input;


class Time implements TimeInterface
{
    /**
     * @var int
     */
    private $minutes;
    /**
     * @var int
     */
    private $seconds;

    /**
     * Time constructor.
     */
    public function __construct(int $minutes, int $seconds)
    {
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->minutes;
    }

    /**
     * @return int
     */
    public function getSeconds(): int
    {
        return $this->seconds;
    }
}