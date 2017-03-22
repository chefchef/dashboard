<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\Dashboards\DashboardEntity;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class AddWidgetToDashboardRequest.
 */
class UpdateWidgetToDashboardRequest extends BaseRequest
{
    /**
     * @var DashboardEntity
     */
    public $dashboard;

    /**
     * @var WidgetInstanceEntity
     */
    public $widgetInstance;

    public $conn;
}
