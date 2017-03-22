<?php

namespace AppBundle\Domain\WidgetInstancesData;

/**
 * Class WidgetInstanceDataFactory.
 */
class WidgetInstanceDataFactory
{
    /**
     * @param $idType
     *
     * @return WidgetInstanceClockData
     *
     * @throws \InvalidArgumentException
     */
    public function getInstance($idType)
    {
        switch ($idType) {
            case 1:
                return new WidgetInstanceClockData();
            case 2:
                return new WidgetInstanceTextData();
            case 3:
                return new WidgetInstanceSystemData();
            case 4:
                return new WidgetInstanceSystemMemoryData();
            default:
                throw new \InvalidArgumentException('Data not found');
        }
    }
}
