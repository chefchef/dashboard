<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class DeleteWidgetInstanceResponse.
 */
class DeleteWidgetInstanceResponse extends BaseResponse
{
    /**
     * @var WidgetInstanceEntity
     */
    public $data;

    /**
     * @return mixed
     */
    public function toArray()
    {
        return [];
    }
}
