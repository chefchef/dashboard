<?php

namespace AppBundle\Application\Widgets\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\Widgets\WidgetEntity;

/**
 * Class FetchWidgetResponse.
 */
class FetchWidgetResponse extends BaseResponse
{
    /**
     * @var WidgetEntity
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

        return  [
            $this->data->toArray(),
        ];
    }
}
