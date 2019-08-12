<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 25/11/2018
 * Time: 10:18
 */

namespace Core\Bus;


use App\Roles\PanelRole;
use Core\Auth\AuthService;
use Core\Auth\AuthServiceInterface;
use Core\Commands\CommandInterface;
use Core\Log\Service\LogServiceInterface;
use Core\Log\Type\LogType;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Reflection\Finders\ResourcesFinderInterface;
use DateTime;

class LoggedCommandBus extends SimpleCommandBus
{
    /**
     * @var \Core\Log\Service\LogServiceInterface
     */
    private $logService;

    /**
     * SimpleCommandBus constructor.
     *
     * @param ResourcesFinderInterface $resourcesFinder
     * @param AuthServiceInterface $authService
     * @param \Core\Log\Service\LogServiceInterface $logService
     */
    public function __construct(ResourcesFinderInterface $resourcesFinder, AuthServiceInterface $authService,
                                LogServiceInterface $logService)
    {
        parent::__construct($resourcesFinder, $authService);
        $this->logService = $logService;
    }

    protected function onAfterFindHandler(CommandInterface $command)
    {

    }

    protected function onResponse(HandlerResponseInterface $response, CommandInterface $command, array $logResponse)
    {
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 300) {
            $isLogin = array_key_exists("session_token", $response->getData());
            if ($isLogin) {
                $log = $this->logService->createLog(new LogType("LOGIN"));
                $this->logService->save($log, $isLogin ? $this->getUserId($response->getData()["session_token"]) : null);
            } else
                $this->saveLogAfterCheckResponse($command, $logResponse);
        }
    }

    private function getUserId($token)
    {
        $matchesID = [];
        preg_match('/id":(\d|\d+|null),/', base64_decode($token), $matchesID);
        return $matchesID[1];
    }

    private function removeImages(array &$data)
    {
        array_walk_recursive($data, function (&$value, $key) {
            if (is_string($value) && substr($value, 0, 11) === "data:image/")
                $value = "[IMAGE]";
        });
    }
    private function removePassword(array &$data)
    {
        array_walk_recursive($data, function (&$value, $key) {
            if (is_string($key) && strpos($key, "password"))
                $value = "****";
        });
    }
    protected function onException(\Throwable $exception, CommandInterface $command)
    {
        $log = $this->logService->createLog(new LogType("exception"));
        $data = [
            "message" => $exception->getMessage(),
            "code" => $exception->getCode(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
            "data" => ["type" => $command->getHttpVerb()
                , "resource" => $command->getResourceName()->getCamelCase(),
                "table" => $command->getResourceName()->getSnakeCase(),
                "data" => $command->getActionName()->getSnakeCase() !== "login"
                && $command->getActionName()->getSnakeCase() !== "register"
                && $command->getActionName()->getSnakeCase() !== "change_password_panel"
                && $command->getActionName()->getSnakeCase() !== "change_password" ? $command->all() : [],
                "id" => $command->getUrlIdParameter(),
                "url" => $command->getHeader("referer"),
            ],
        ];
        $this->removeImages($data);
        $this->removePassword($data);

        $log->setData($data);
        $this->logService->save($log);
    }

    /**
     * @param CommandInterface $command
     * @param array $logResponse
     */
    protected function saveLogAfterCheckResponse(CommandInterface $command, array $logResponse): void
    {
        $log = $this->logService->createLog(new LogType(array_key_exists("method", $logResponse) ? $logResponse["method"] : $command->getHttpVerb()));
        $data = [
            "data" => ["type" => $command->getHttpVerb(),
                "custom" => array_key_exists("data", $logResponse) ? $logResponse["data"] : ""
                , "resource" => $command->getResourceName()->getCamelCase(),
                "table" => $command->getResourceName()->getSnakeCase(),
                "data" => $command->getActionName()->getSnakeCase() !== "login"
                && $command->getActionName()->getSnakeCase() !== "register"
                && $command->getActionName()->getSnakeCase() !== "change_password_panel"
                && $command->getActionName()->getSnakeCase() !== "change_password" ? $command->all() : [],
                "id" => $command->getUrlIdParameter(),
                "url" => $command->getHeader("referer"),
            ],
        ];
        if (array_key_exists("params", $logResponse) && count($logResponse["params"]) > 0)
            $data["data"]["data"] = $logResponse["params"];
        $this->removeImages($data);
        $this->removePassword($data);
        $log->setData($data);
        if ($log->getUser()->getRole() instanceof PanelRole)
            $this->logService->save($log);
    }
}