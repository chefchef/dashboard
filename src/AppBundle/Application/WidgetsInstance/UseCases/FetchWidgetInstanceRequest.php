<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\Dashboards\DashboardEntity;

/**
 * Class FetchWidgetRequest.
 */
class FetchWidgetInstanceRequest extends BaseRequest
{
    public $conn;

    /**
     * @var DashboardEntity
     */
    public $dashboard;
    /**
     * @var int
     */
    public $idWidgetInstance;
}
