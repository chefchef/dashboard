<?php

namespace AppBundle\Domain\WidgetInstancesData;

use Carbon\Carbon;

/**
 * Class WidgetInstanceClockData.
 */
class WidgetInstanceClockData implements WidgetInstanceDataEntity
{
    protected $idWidgetInstance;

    public $actualDate;

    /**
     * @return mixed
     */
    public function generateData()
    {
        return [
            'data' => ['clock' => Carbon::now()->toRfc2822String()],
            'refresh' => 5,
        ];
    }
}
