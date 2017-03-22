<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\Dashboards\DashboardEntity;
use AppBundle\Domain\Widgets\WidgetEntity;

/**
 * Class AddWidgetToDashboardRequest.
 */
class AddWidgetToDashboardRequest extends BaseRequest
{
    /**
     * @var DashboardEntity
     */
    public $dashboard;

    /**
     * @var WidgetEntity
     */
    public $widget;

    public $name;

    public $conn;
}
