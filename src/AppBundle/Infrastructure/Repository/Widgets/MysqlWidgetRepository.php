<?php

namespace AppBundle\Infrastructure\Repository\Widgets;

use AppBundle\Domain\Widgets\Widget;
use AppBundle\Domain\Widgets\WidgetEntity;
use AppBundle\Domain\Widgets\WidgetRepository;

/**
 * Class MysqlWidgetRepository.
 */
class MysqlWidgetRepository implements WidgetRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $conn;

    /**
     * @param $conn
     *
     * @return mixed
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param WidgetEntity $widgetEntity
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @internal param WidgetEntity $dasboard
     */
    public function create(WidgetEntity $widgetEntity)
    {
        $prepare = $this->conn->prepare('
          INSERT INTO widgets (`id`, `name`) VALUES (?, ?)
        ');
        $prepare->bindValue(1, $widgetEntity->id());
        $prepare->bindValue(2, $widgetEntity->name());

        return $prepare->execute();
    }

    /**
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function fetchAll()
    {
        $prepare = $this->conn->prepare('
          SELECT `id`, `name` FROM widgets
        ');
        $prepare->execute();

        $data = $prepare->fetchAll();

        if (null !== $data) {
            $widgets = [];

            /*
             * @var array
             */
            foreach ($data as $item) {
                $widget = Widget::createEntity($item['id'], $item['name']);
                $widgets[] = $widget;
            }

            return $widgets;
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return Widget|bool
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function fetch($id)
    {
        $prepare = $this->conn->prepare('
          SELECT `id`, `name` FROM widgets
          WHERE
            id = ?
        ');
        $prepare->bindValue(1, $id);
        $prepare->execute();

        $item = $prepare->fetch();

        if ($item) {
            return Widget::createEntity($item['id'], $item['name']);
        }

        return false;
    }
}
