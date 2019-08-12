<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:40
 */

namespace Core\Auth\Session;


interface SessionTokenInterface
{
    public function getToken(): string;

    public function getUserId(): ?int;

    public function getExpirationDate(): \DateTime;

    public function isCorrect(): bool;

    public function updateSession();
}