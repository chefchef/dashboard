<?php

namespace AppBundle\Domain\Widgets;

use Ramsey\Uuid\Uuid;

/**
 * Class Widget.
 */
class Widget implements WidgetEntity
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $name;

    /**
     * Widget constructor.
     *
     * @param $name
     * @param bool $new
     */
    protected function __construct($name, $new = false)
    {
        if ($new) {
            $this->id = Uuid::uuid4()->toString();
        }

        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    protected function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function create($name)
    {
        return new self($name, true);
    }

    /**
     * @param $id
     * @param $name
     *
     * @return Widget
     */
    public static function createEntity($id, $name)
    {
        $widget = new self($name, false);
        $widget->setId($id);

        return $widget;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
        ];
    }
}
