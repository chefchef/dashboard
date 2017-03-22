<?php

namespace AppBundle\Domain\Dashboards;

use AppBundle\Domain\Users\UserEntity;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DashBoard.
 */
class DashBoard implements DashboardEntity
{
    /**
     * @var int
     */
    protected $idUser;

    /**
     * @var string
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $name;

    /**
     * @var WidgetInstanceEntity[]
     */
    protected $widgets;

    /**
     * DashBoard constructor.
     *
     * @param UserEntity $user
     * @param null       $name
     * @param bool       $new
     *
     * @throws \InvalidArgumentException
     */
    protected function __construct(UserEntity $user = null, $name = null, $new = true)
    {
        if (null !== $user) {
            if (!$user->isValid()) {
                throw new \InvalidArgumentException('User not valid to create dashboard');
            }

            $this->setIdUser($user->id());
        }

        $this->name = $name;

        if ($new) {
            $this->setId(Uuid::uuid4()->toString());
        }
    }

    /**
     * @param WidgetInstanceEntity $widget
     *
     * @return mixed
     */
    public function addWidget(WidgetInstanceEntity $widget)
    {
        $this->widgets[] = $widget;
    }

    /**
     * @return mixed
     */
    public function idUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    protected function setIdUser($idUser)
    {
        $this->idUser = $idUser;
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
     * @return WidgetInstanceEntity[]
     */
    public function widgets()
    {
        return $this->widgets;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param $user
     * @param $name
     *
     * @return DashBoard
     *
     * @throws \InvalidArgumentException
     */
    public static function create($user, $name)
    {
        return new self($user, $name);
    }

    /**
     * @param $user
     * @param $id
     * @param $name
     *
     * @return DashBoard
     *
     * @throws \InvalidArgumentException
     */
    public static function createEntity($user, $id, $name)
    {
        $dashboard = new self($user, $name, false);
        $dashboard->setId($id);

        return $dashboard;
    }

    /**
     * @param $user
     *
     * @return DashBoard
     *
     * @throws \InvalidArgumentException
     */
    public static function createFormEntity($user)
    {
        return new self($user, '', false);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $res = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        return $res;
    }
}
