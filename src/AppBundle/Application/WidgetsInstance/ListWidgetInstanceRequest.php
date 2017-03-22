<?php

namespace AppBundle\Application\WidgetsInstance;

use AppBundle\Domain\Core\BaseRequest;

/**
 * Class ListWidgetInstanceRequest.
 */
class ListWidgetInstanceRequest extends BaseRequest
{
    public $conn;

    public $dashboard;
}
