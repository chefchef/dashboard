<?php

namespace AppBundle\Domain\Dashboards;

use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class DasboardEntity.
 */
interface DashboardEntity
{
    /**
     * @param WidgetInstanceEntity $widget
     *
     * @return mixed
     */
    public function addWidget(WidgetInstanceEntity $widget);

    public function id();

    public function name();

    public function idUser();

    /**
     * @param $user
     * @param $name
     *
     * @return mixed
     */
    public static function create($user, $name);

    /**
     * @param $user
     *
     * @return mixed
     */
    public static function createFormEntity($user);

    /**
     * @return WidgetInstanceEntity[]
     */
    public function widgets();

    /**
     * @return mixed
     */
    public function toArray();
}
