<?php

namespace AppBundle\Application\WidgetsInstance;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;

/**
 * Class ListWidgetInstanceResponse.
 */
class ListWidgetInstanceResponse extends BaseResponse
{
    /**
     * @return mixed
     */
    public function toArray()
    {
        $res = [];

        /*
         * @var WidgetInstanceEntity[]
         */
        $listWidgetsdata = $this->data;

        foreach ($listWidgetsdata as $widgetInstance) {
            $res[] = $widgetInstance->toArray();
        }

        return $res;
    }
}
