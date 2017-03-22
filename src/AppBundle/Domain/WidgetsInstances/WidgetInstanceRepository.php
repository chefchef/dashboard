<?php

namespace AppBundle\Domain\WidgetsInstances;

use AppBundle\Domain\Dashboards\DashboardEntity;

/**
 * Interface WidgetInstanceRepository.
 */
interface WidgetInstanceRepository
{
    /**
     * @param $conn
     */
    public function setConn($conn);

    /***
     * @param WidgetInstanceEntity $widgetInstanceEntity
     * @return mixed
     */
    public function create(WidgetInstanceEntity $widgetInstanceEntity);

    /**
     * @param DashboardEntity $dashboard
     *
     * @return WidgetInstance[]
     */
    public function fetchAll(DashboardEntity $dashboard);

    /**
     * @param DashboardEntity $dashboard
     * @param $idWidgetInstance
     *
     * @return mixed
     */
    public function fetch(DashboardEntity $dashboard, $idWidgetInstance);

    /**
     * @param DashboardEntity $dashboard
     * @param $idWidgetInstance
     *
     * @return mixed
     */
    public function delete(DashboardEntity $dashboard, $idWidgetInstance);

    /**
     * @param DashboardEntity      $dashboardEntity
     * @param WidgetInstanceEntity $widgetInstanceEntity
     *
     * @return mixed
     */
    public function update(DashboardEntity $dashboardEntity, WidgetInstanceEntity $widgetInstanceEntity);
}
