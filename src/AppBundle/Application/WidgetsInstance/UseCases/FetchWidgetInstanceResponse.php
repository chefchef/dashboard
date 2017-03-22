<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class FetchWidgetResponse.
 */
class FetchWidgetInstanceResponse extends BaseResponse
{
    /**
     * @var WidgetInstanceEntity
     */
    public $data;

    /**
     * @return array|null
     */
    public function toArray()
    {
        if ((null === $this->data) || (false === $this->data)) {
            return [];
        }

        return $this->data->toArray();
    }

    /**
     * @return array|null
     */
    public function toArrayInfo()
    {
        if ((null === $this->data) || (false === $this->data)) {
            return [];
        }

        return $this->data->toArrayInfo();
    }
}
