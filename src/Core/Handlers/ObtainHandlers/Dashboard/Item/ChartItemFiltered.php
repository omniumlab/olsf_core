<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 09/03/2018
 * Time: 10:20
 */

namespace Core\Handlers\ObtainHandlers\Dashboard\Item;


class ChartItemFiltered extends Item
{
    const TYPE_LINE = "line";
    const TYPE_BAR = "bar";
    const TYPE_RADAR = "radar";
    const TYPE_PIE = "pie";
    const TYPE_POLAR_AREAR = "polarArea";
    const TYPE_DOUGHNUT = "doughnut";

    /*
     * Class variables
     * "labels" string[]
     * "type" string
     * "legend" bool
     */

    /**
     * ChartItem constructor.
     * @param null|string $name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setItemType("chart-filtered");
        $this->setType(ChartItem::TYPE_PIE);
        $this->setLegend(true);
    }

    /**
     * @param $labels string[]
     */
    public function setLabels($labels)
    {
        $this->setVariable("labels", $labels);
    }

    /**
     * @param $type string
     */
    public function setType($type)
    {
        $this->setVariable("type", $type);
    }

    /**
     * @param $legend string
     */
    public function setLegend($legend)
    {
        $this->setVariable("legend", $legend);
    }

    /**
     * @param $filters
     */
    public function setFilters($filters)
    {
        $this->setVariable("filters", $filters);
    }    /**
     * @param $filter
     */
    public function setDefaultFilter($filter)
    {
        $this->setVariable("selected", $filter);
    }
}