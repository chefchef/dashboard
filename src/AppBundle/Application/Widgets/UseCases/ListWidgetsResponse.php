<?php

namespace AppBundle\Application\Widgets\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\Widgets\WidgetEntity;

/**
 * Class ListWidgetsResponse.
 */
class ListWidgetsResponse extends BaseResponse
{
    /**
     * @var WidgetEntity[]
     */
    public $data;

    /**
     * @return array
     */
    public function toArray()
    {
        $res = [];

        /*
         * @var->data WidgetEntity[]
         */
        foreach ($this->data as $widget) {
            $res[] = $widget->toArray();
        }

        return $res;
    }
}
