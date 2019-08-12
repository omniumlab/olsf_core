<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 11:59
 */

namespace Core\Log\Service;


use Core\Auth\AuthService;
use Core\Auth\AuthServiceInterface;
use Core\Log\Log;
use Core\Log\LogInterface;
use Core\Log\Repository\LogRepositoryInterface;
use Core\Log\Type\LogTypeInterface;

class LogService implements LogServiceInterface
{
    private $user;
    /**
     * @var \DateTime
     */
    private $sessionStartDate;
    /**
     * @var \Core\Log\Repository\LogRepositoryInterface
     */
    private $logRepository;
    private $authService;


    /**
     * DatabaseLogService constructor.
     *
     * @param \Core\Auth\AuthServiceInterface $authService
     * @param \Core\Log\Repository\LogRepositoryInterface $logRepository
     */
    public function __construct(AuthServiceInterface $authService, LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
        $this->authService = $authService;
    }

    public function createLog(LogTypeInterface $type): LogInterface
    {
        $this->user = $this->authService->getCurrentConnectedUser();
        return new Log($type, $this->getSessionStartDate(), $this->user);
    }

    private function getSessionStartDate(): \DateTime
    {
        if ($this->sessionStartDate === null) {
            $this->sessionStartDate = new \DateTime();
        }

        return $this->sessionStartDate;
    }

    public function save(LogInterface $log, string $userid = null)
    {
        $this->logRepository->insert($log,$userid);
    }
}