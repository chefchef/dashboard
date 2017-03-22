<?php

namespace AppBundle\Infrastructure\Repository\WidgetInstance;

use AppBundle\Domain\Dashboards\DashboardEntity;
use AppBundle\Domain\WidgetsInstances\WidgetInstance;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceRepository;

/**
 * Class MysqlWidgetInstanceRepository.
 */
class MysqlWidgetInstanceRepository implements WidgetInstanceRepository
{
    const SIZEX_DEFAULT = 200;
    const SIZEY_DEFAULT = 200;
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
     * @param WidgetInstanceEntity $widgetInstanceEntity
     *
     * @return bool
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create(WidgetInstanceEntity $widgetInstanceEntity)
    {
        $prepare = $this->conn->prepare('
          INSERT INTO widgets_instances (`id`, `idWidget`,`idDashboard`,`name`, `sizeX`, `sizeY`)
          VALUES (?, ?, ?, ?, ? , ?)
        ');
        $prepare->bindValue(1, $widgetInstanceEntity->id());
        $prepare->bindValue(2, $widgetInstanceEntity->idWidget());
        $prepare->bindValue(3, $widgetInstanceEntity->idDashboard());
        $prepare->bindValue(4, $widgetInstanceEntity->name());
        $prepare->bindValue(5, self::SIZEX_DEFAULT);
        $prepare->bindValue(6, self::SIZEY_DEFAULT);

        return $prepare->execute();
    }

    /**
     * @param DashboardEntity $dashboard
     *
     * @return mixed
     */
    public function fetchAll(DashboardEntity $dashboard)
    {
        $prepare = $this->conn->prepare('
            SELECT `id`, `idWidget`,`idDashboard`,`name`, `sizeX`, `sizeY` FROM widgets_instances
            WHERE
               `idDashboard` = ?
        ');

        $prepare->bindValue(1, $dashboard->id());
        $prepare->execute();

        $data = $prepare->fetchAll();

        if (null !== $data) {
            $widgetsInstances = [];

            /*
             * @var array
             */
            foreach ($data as $item) {
                $widgetInstance = WidgetInstance::createEntity($item['idWidget'], $item['idDashboard'], $item['name']);
                $widgetInstance->setId($item['id']);
                $widgetInstance->setSize($item['sizeX'], $item['sizeY']);
                $widgetsInstances[] = $widgetInstance;
            }

            return $widgetsInstances;
        }

        return false;
    }

    /**
     * @param DashboardEntity $dashboard
     * @param int             $idWidgetInstance
     *
     * @return mixed
     */
    public function fetch(DashboardEntity $dashboard, $idWidgetInstance)
    {
        $prepare = $this->conn->prepare('
            SELECT `id`, `idWidget`,`idDashboard`,`name`, `sizeX`, `sizeY`, `positionX`, `positionY`
            FROM widgets_instances
            WHERE
               `idDashboard` = ? AND
               `id` = ?
           LIMIT 1
        ');

        $prepare->bindValue(1, $dashboard->id());
        $prepare->bindValue(2, $idWidgetInstance);
        $prepare->execute();

        $item = $prepare->fetch();

        if ($item) {
            $widgetInstance = WidgetInstance::createEntity($item['idWidget'], $item['idDashboard'], $item['name']);
            $widgetInstance->setId($item['id']);
            $widgetInstance->setSize($item['sizeX'], $item['sizeY']);
            $widgetInstance->setPosition($item['positionX'], $item['positionY']);

            return $widgetInstance;
        }

        return false;
    }

    /**
     * @param DashboardEntity $dashboard
     * @param $idWidgetInstance
     *
     * @return mixed
     */
    public function delete(DashboardEntity $dashboard, $idWidgetInstance)
    {
        $prepare = $this->conn->prepare('DELETE FROM widgets_instances WHERE
               `idDashboard` = ? AND
               `id` = ?
           LIMIT 1');

        $prepare->bindValue(1, $dashboard->id());
        $prepare->bindValue(2, $idWidgetInstance);
        $res = $prepare->execute();

        return $res;
    }

    /**
     * @param DashboardEntity      $dashboardEntity
     * @param WidgetInstanceEntity $widgetInstanceEntity
     *
     * @return mixed
     */
    public function update(DashboardEntity $dashboardEntity, WidgetInstanceEntity $widgetInstanceEntity)
    {
        $res = $this->conn->update(
            'widgets_instances',
            $widgetInstanceEntity->toArrayNoKeys(),
            [
                'idDashboard' => $dashboardEntity->id(),
                'id' => $widgetInstanceEntity->id(),
            ]
        );

        return $res;
    }
}
