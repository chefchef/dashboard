<?php

namespace AppBundle\Infrastructure\Repository\WidgetsType;

use AppBundle\Domain\Widgets\WidgetEntity;
use AppBundle\Domain\WidgetsType\WidgetType;
use AppBundle\Domain\WidgetsType\WidgetTypeRepository;

/**
 * Class MysqlWidgetTypeRepository.
 */
class MysqlWidgetTypeRepository implements WidgetTypeRepository
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
     * @param WidgetEntity $widget
     *
     * @return mixed
     */
    public function fetch(WidgetEntity $widget)
    {
        $prepare = $this->conn->prepare('
            SELECT `idWidget`,`data`
            FROM widget_type
            WHERE
               `idWidget` = ?
           LIMIT 1
        ');

        $prepare->bindValue(1, $widget->id());
        $prepare->execute();

        $item = $prepare->fetch();

        if ($item) {
            return WidgetType::create($item['idWidget'], $item['data']);
        }

        return false;
    }
}
