<?php

namespace Core\Handlers\ObtainHandlers\Dashboard;

use Core\Commands\CommandInterface;
use Core\Handlers\Handler;
use Core\Handlers\ObtainHandlers\Dashboard\Summary\Summary;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractDashboardHandler extends Handler implements DashboardHandlerInterface
{
    /** @var  Group[] */
    private $groups = [];

    /** @var Summary[] */
    private $summarys = [];

    /** @var CommandInterface */
    private $command;

    public function __construct(TextHandlerInterface $textHandle)
    {
        parent::__construct("GET", false, $textHandle);
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->command = $command;
        $this->setup();

        $valuesGroups = [];
        $valuesSummary = [];

        $this->configDashboard();
        $this->configSummary();

        foreach ($this->groups as $group) {
            $valuesGroups[] = $group->getValues();
        }

        foreach ($this->summarys as $summary) {
            $valuesSummary[] = $summary->getValues();
        }

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [
            "summary" => $valuesSummary,
            "groups" => $valuesGroups,
        ]);
    }

    abstract function configDashboard();

    abstract function configSummary();

    /**
     * Add a group to the dashboard and return it to be configured with the necessary data.
     *
     * @param int $columns
     *
     * @return Group
     */
    public function addGroup($columns = 1)
    {
        $group = new Group($columns);
        $this->groups[] = $group;

        return $group;
    }

    public function addSummary($title, $icon, $value, $iconColor = null)
    {
        $summary = new Summary($title, $icon, $value);
        if ($iconColor !== null) {
            $summary->setIconColor($iconColor);
        }
        $this->summarys[] = $summary;
    }

    /**
     * @return CommandInterface
     */
    protected function getCommand(): CommandInterface
    {
        return $this->command;
    }

}
