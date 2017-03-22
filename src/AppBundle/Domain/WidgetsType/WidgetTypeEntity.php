<?php

namespace AppBundle\Domain\WidgetsType;

/**
 * Class WidgetType.
 */
interface WidgetTypeEntity
{
    /**
     * @return mixed
     */
    public function idWidget();

    /**
     * @return mixed
     */
    public function data();

    /**
     * @param $idWidget
     * @param $data
     *
     * @return mixed
     */
    public static function create($idWidget, $data);
}
