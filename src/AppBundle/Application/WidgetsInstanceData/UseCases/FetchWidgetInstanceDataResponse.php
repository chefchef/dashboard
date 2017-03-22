<?php

namespace AppBundle\Application\WidgetsInstanceData\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class FetchWidgetInstanceDataResponse.
 */
class FetchWidgetInstanceDataResponse extends BaseResponse
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

        if (is_array($this->data)) {
            return $this->data;
        }

        $res = $this->data->toArray();

        return array_merge($res, ['tpl' => $this->tpl]);
    }
}
