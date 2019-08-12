<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 17:28
 */

namespace Core\Log\Repository;


use Core\Log\LogInterface;
use Propel\Runtime\Propel;

class DatabaseLogRepository implements LogRepositoryInterface
{

    public function insert(LogInterface $log, string $userid = null)
    {
        $stmt = Propel::getConnection()->prepare("INSERT INTO `log` (`type`, `session_start_date`, `user_id`, `data`) " .
            "VALUES (:type, :session_start_date, :user_id, :data)");

        $data = $log->getData();

        if (!is_string($data)) {
            if (is_array($data)) {
                $data = json_encode($data);
            } else {
                $data = var_export($data, true);
            }
        }

        $parameters = [
            "type" => $log->getType()->getSlug(),
            "session_start_date" => $log->getSessionStartDate()->format("Y-m-d H:i:s"),
            "user_id" => $userid !== null ? $userid : $log->getUser()->getId(),
            "data" => $data,
        ];

        $stmt->execute($parameters);
    }
}