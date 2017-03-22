<?php

namespace AppBundle\Application\Widgets\UseCases;

use AppBundle\Domain\Core\BaseRequest;

/**
 * Class FetchWidgetRequest.
 */
class FetchWidgetRequest extends BaseRequest
{
    public $conn;

    /**
     * @var int
     */
    public $idWidget;
}
