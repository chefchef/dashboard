<?php

namespace AppBundle\Domain\WidgetInstancesData;

/**
 * Class WidgetInstanceTextData.
 */
class WidgetInstanceTextData implements WidgetInstanceDataEntity
{
    protected $idWidgetInstance;

    /**
     * @return mixed
     */
    public function generateData()
    {
        return [
            'data' => ['text' => 'Hello world!'],
            'refresh' => 300,
        ];
    }
}
