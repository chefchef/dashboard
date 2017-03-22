<?php

namespace AppBundle\Domain\Widgets;

/**
 * Interface WidgetRepository.
 */
interface WidgetRepository
{
    /**
     * @param $conn
     */
    public function setConn($conn);

    /**
     * @param WidgetEntity $widgetEntity
     *
     * @return mixed
     */
    public function create(WidgetEntity $widgetEntity);

    /**
     * @return WidgetEntity[]
     */
    public function fetchAll();

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function fetch($id);
}
