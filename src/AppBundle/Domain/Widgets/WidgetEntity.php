<?php

namespace AppBundle\Domain\Widgets;

/**
 * Interface WidgetEntity.
 */
interface WidgetEntity
{
    /**
     * @param $name
     *
     * @return mixed
     */
    public static function create($name);

    /**
     * @param $id
     * @param $name
     *
     * @return mixed
     */
    public static function createEntity($id, $name);

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return mixed
     */
    public function toArray();
}
