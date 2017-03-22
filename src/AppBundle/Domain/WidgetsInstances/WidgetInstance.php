<?php

namespace AppBundle\Domain\WidgetsInstances;

use AppBundle\Domain\WidgetsType\WidgetType;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WidgetInstance.
 */
class WidgetInstance implements WidgetInstanceEntity
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var WidgetType
     */
    protected $idWidget;

    /**
     * @var string
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $idDashboard;

    /**
     * @var \DateTimeInterface
     */
    protected $creationDate;

    /**
     * @var int
     */
    protected $sizeX;

    /**
     * @var int
     */
    protected $sizeY;

    /**
     * @var int
     */
    protected $positionX;

    /**
     * @var int
     */
    protected $positionY;

    /**
     * WidgetInstance constructor.
     *
     * @param $idWidget
     * @param $idDashboard
     * @param $name
     * @param bool $new
     */
    public function __construct($idWidget, $idDashboard, $name, $new = true)
    {
        if ($new) {
            $this->id = Uuid::uuid4()->toString();
            $this->creationDate = new \DateTimeImmutable();
        }
        $this->idWidget = $idWidget;
        $this->idDashboard = $idDashboard;
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
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function idDashboard()
    {
        return $this->idDashboard;
    }

    /**
     * @param string $idDashboard
     */
    public function setIdDashboard($idDashboard)
    {
        $this->idDashboard = $idDashboard;
    }

    /**
     * @return WidgetType
     */
    public function idWidget()
    {
        return $this->idWidget;
    }

    /**
     * @return int
     */
    public function sizeX()
    {
        return $this->sizeX;
    }

    /**
     * @return int
     */
    public function sizeY()
    {
        return $this->sizeY;
    }

    /**
     * @return int
     */
    public function positionX()
    {
        return $this->positionX;
    }

    /**
     * @return int
     */
    public function positionY()
    {
        return $this->positionY;
    }

    /**
     * @param $sizeX
     * @param $sizeY
     */
    public function setSize($sizeX, $sizeY)
    {
        $this->sizeX = (int) $sizeX;
        $this->sizeY = (int) $sizeY;
    }

    /**
     * @param $positionX
     * @param $positionY
     *
     * @return mixed
     */
    public function setPosition($positionX, $positionY)
    {
        $this->positionX = (int) $positionX;
        $this->positionY = (int) $positionY;
    }

    /**
     * @param $idWidget
     * @param $idDashboard
     * @param $name
     *
     * @return WidgetInstance
     */
    public static function create($idWidget, $idDashboard, $name)
    {
        return new self($idWidget, $idDashboard, $name);
    }

    /**
     * @return WidgetInstance
     *
     * @throws \InvalidArgumentException
     */
    public static function createFormEntity()
    {
        return new self(null, null, null, false);
    }

    /**
     * @param $idWidget
     * @param $idDashboard
     * @param $name
     *
     * @return WidgetInstance
     */
    public static function createEntity($idWidget, $idDashboard, $name)
    {
        return new self($idWidget, $idDashboard, $name, false);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $res = [
            'id' => $this->id,
            'idWidget' => $this->idWidget,
            'idDashboard' => $this->idDashboard,
        ];

        return $res;
    }

    /**
     * @return array
     */
    public function toArrayNoKeys()
    {
        $res = [
            'name' => $this->name,
            'sizeX' => $this->sizeX,
            'sizeY' => $this->sizeY,
            'positionX' => $this->positionX,
            'positionY' => $this->positionY,
        ];

        return $res;
    }

    /**
     * @return array
     */
    public function toArrayInfo()
    {
        $res = [
            'positionX' => $this->positionX,
            'positionY' => $this->positionY,
            'sizeX' => $this->sizeX,
            'sizeY' => $this->sizeY,
        ];

        return $res;
    }
}
