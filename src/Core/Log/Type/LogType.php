<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 12:43
 */

namespace Core\Log\Type;


class LogType implements LogTypeInterface
{

    /**
     * @var string
     */
    private $slug;

    /**
     * LogType constructor.
     *
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }


    public function getSlug(): string
    {
        return $this->slug;
    }
}