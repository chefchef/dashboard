<?php

namespace AppBundle\Domain\WidgetInstancesData;

/**
 * Interface WidgetInstanceDataEntity.
 */
interface WidgetInstanceDataEntity
{
    const NORMAL_LEVEL = 'success';
    const WARNING_LEVEL = 'warning';
    const ERROR_LEVEL = 'danger';

    public function generateData();
}
