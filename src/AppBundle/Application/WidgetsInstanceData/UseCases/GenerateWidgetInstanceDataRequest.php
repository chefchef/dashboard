<?php

namespace AppBundle\Application\WidgetsInstanceData\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class FetchWidgetInstanceDataRequest.
 */
class GenerateWidgetInstanceDataRequest extends BaseRequest
{
    public $conn;

    /**
     * @var WidgetInstanceEntity
     */
    public $widgetInstance;
}
