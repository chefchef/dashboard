<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\Dashboards\DashboardEntity;

/**
 * Class DeleteWidgetRequest.
 */
class DeleteWidgetInstanceRequest extends BaseRequest
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
