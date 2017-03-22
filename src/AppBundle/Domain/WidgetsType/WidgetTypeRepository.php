<?php

namespace AppBundle\Domain\WidgetsType;

use AppBundle\Domain\Widgets\WidgetEntity;

/**
 * Interface WidgetTypeRepository.
 */
interface WidgetTypeRepository
{
    /**
     * @param $conn
     */
    public function setConn($conn);

    /**
     * @param WidgetEntity $widget
     *
     * @return mixed
     */
    public function fetch(WidgetEntity $widget);
}
