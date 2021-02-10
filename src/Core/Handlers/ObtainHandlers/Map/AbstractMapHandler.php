<?php

namespace Core\Handlers\ObtainHandlers\Map;

use Core\Commands\CommandInterface;
use Core\Handlers\Handler;
use Core\Handlers\ObtainHandlers\Dashboard\Summary\Summary;
use Core\Handlers\ObtainHandlers\Map\Data\Coordinate;
use Core\Handlers\ObtainHandlers\Map\Data\Marker;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Text\TextHandlerInterface;

abstract class AbstractMapHandler extends Handler implements MapHandlerInterface
{


    private $center;
    /** @var CommandInterface */
    private $command;
    /**
     * @var int
     */
    private $zoom = 10;
    /**
     * @var array
     */
    private $markers = [];
    private $timeout = 0;

    public function __construct(TextHandlerInterface $textHandle)
    {
        $this->center = new Coordinate(40.416905, -3.703456);
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

        $valuesMarkers = [];

        $this->configMap($this->command);

        foreach ($this->markers as $marker) {
            $valuesMarkers[] = $marker->getValues();
        }


        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [
            "markers" => $valuesMarkers,
            "center" => $this->center->getValues(),
            "zoom" => $this->zoom,
            "timeout" => $this->timeout,
        ]);
    }

    abstract function configMap(CommandInterface $command);


    /**
     *
     * @param Coordinate $coordinate
     */
    public function setCenter($coordinate)
    {
        $this->center = $coordinate;
    }

    public function setZoom(int $zoom)
    {
        $this->zoom = $zoom;
    }

    public function addMarker($latitude, $longitude, $textDialog = null, $titleDialog = null, $iconbase64 = null)
    {
        $mark = new Marker(new Coordinate($latitude, $longitude));
        if ($iconbase64 !== null) {
            $mark->setIconBase64($iconbase64);
        }
        if ($textDialog !== null) {
            $mark->setTextDialog($textDialog);
        }
        if ($titleDialog !== null) {
            $mark->setTitleDialog($titleDialog);
        }
        $this->markers[] = $mark;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @return CommandInterface
     */
    protected function getCommand(): CommandInterface
    {
        return $this->command;
    }

}
