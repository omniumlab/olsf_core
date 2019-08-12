<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 12:10
 */

namespace Core\Log;


use Core\Auth\User\AuthUserInterface;
use Core\Log\Type\LogTypeInterface;

class Log implements LogInterface
{
    /**
     * @var LogTypeInterface
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $sessionStartDate;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var AuthUserInterface|null
     */
    private $user;

    /**
     * @var array
     */
    private $data = [];

    /**
     * Log constructor.
     *
     * @param LogTypeInterface $type
     * @param \DateTime $sessionStartDate
     * @param \Core\Auth\User\AuthUserInterface $user
     */
    public function __construct(LogTypeInterface $type, \DateTime $sessionStartDate, ?AuthUserInterface $user)
    {
        $this->type = $type;
        $this->sessionStartDate = $sessionStartDate;

        $this->timestamp = new \DateTime();
        $this->user = $user;
    }

    /**
     * @return LogTypeInterface
     */
    public function getType(): LogTypeInterface
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getSessionStartDate(): \DateTime
    {
        return $this->sessionStartDate;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return \Core\Auth\User\AuthUserInterface|null
     */
    public function getUser(): ?AuthUserInterface
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }


}