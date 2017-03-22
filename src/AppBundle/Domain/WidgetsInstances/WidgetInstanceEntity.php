<?php

namespace AppBundle\Domain\WidgetsInstances;

/**
 * Class WidgetInstance.
 */
interface WidgetInstanceEntity
{
    /**
     * @return mixed
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @param mixed $id
     */
    public function setId($id);

    /**
     * @return int
     */
    public function idDashboard();

    /**
     * @return int
     */
    public function idWidget();

    /**
     * @param $sizeX
     * @param $sizeY
     */
    public function setSize($sizeX, $sizeY);

    /**
     * @param $positionX
     * @param $positionY
     *
     * @return mixed
     */
    public function setPosition($positionX, $positionY);

    /**
     * @param $idWidget
     * @param $idDashboard
     * @param $name
     *
     * @return mixed
     */
    public static function create($idWidget, $idDashboard, $name);

    /**
     * @return mixed
     */
    public static function createFormEntity();

    /**
     * @param $idWidget
     * @param $idDashboard
     * @param $name
     *
     * @return mixed
     */
    public static function createEntity($idWidget, $idDashboard, $name);

    /**
     * @return mixed
     */
    public function toArray();

    /**
     * @return mixed
     */
    public function toArrayNoKeys();

    /**
     * @return mixed
     */
    public function toArrayInfo();
}
