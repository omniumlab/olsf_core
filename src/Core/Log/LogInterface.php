<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 11:13
 */

namespace Core\Log;


use Core\Auth\User\AuthUserInterface;
use Core\Log\Type\LogTypeInterface;

interface LogInterface
{
    public function getType(): LogTypeInterface;

    public function getSessionStartDate(): \DateTime;

    public function getTimestamp(): \DateTime;

    public function getUser(): ?AuthUserInterface;

    /**
     * @return mixed
     */
    public function getData();

    public function setData(array $data);
}