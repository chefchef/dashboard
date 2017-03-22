<?php

namespace AppBundle\Domain\WidgetsType;

/**
 * Class WidgetType.
 */
class WidgetType implements WidgetTypeEntity
{
    /**
     * @var string
     */
    protected $idWidget;

    /**
     * @var string
     */
    protected $data;

    /**
     * WidgetType constructor.
     *
     * @param $idWidget
     * @param string $data
     */
    private function __construct($idWidget, $data)
    {
        $this->idWidget = $idWidget;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function idWidget()
    {
        return $this->idWidget;
    }

    /**
     * @return string
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @param int    $idWidget
     * @param string $data
     *
     * @return WidgetType
     */
    public static function create($idWidget, $data)
    {
        return new self($idWidget, $data);
    }
}
