<?php

namespace AppBundle\Infrastructure\Repository\Dashboards;

use AppBundle\Domain\Dashboards\DashboardEntity;
use AppBundle\Domain\Dashboards\DashboardRepository;
use AppBundle\Domain\Users\UserEntity;
use AppBundle\Domain\Dashboards\DashBoard;

/**
 * Class MysqlDasboardRepository.
 */
class MysqlDasboardRepository implements DashboardRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $conn;

    /**
     * @param $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param DashboardEntity $dasboard
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create(DashboardEntity $dasboard)
    {
        $prepare = $this->conn->prepare('
          INSERT INTO dashboards (`idUser`, `id`, `name`) VALUES (?, ?, ?)
        ');
        $prepare->bindValue(1, $dasboard->idUser());
        $prepare->bindValue(2, $dasboard->id());
        $prepare->bindValue(3, $dasboard->name());

        return $prepare->execute();
    }

    /**
     * @param DashboardEntity $dasboard
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update(DashboardEntity $dasboard)
    {
        // @todo begin trans
        try {
            $prepare = $this->conn->prepare('UPDATE dashboards SET (`name`) VALUES (?) WHERE idUser = ? AND id = ?');

            $prepare->bindValue(1, $dasboard->name());
            $prepare->bindValue(2, $dasboard->idUser());
            $prepare->bindValue(3, $dasboard->id());
            $prepare->execute();

            $widgets = $dasboard->widgets();

            if (0 !== count($widgets)) {
                foreach ($widgets as $widget) {
                    $prepare = $this->conn->prepare('UPDATE widget_instance
                                                     SET (`name`) VALUES (?) WHERE id_dashboard = ?
                                                     ');
                    $prepare->bindValue(1, $widget->name());
                    $prepare->bindValue(2, $dasboard->id());
                    $prepare->execute();
                }
            }
        } catch (\Exception $e) {
            // @todo rollback

            return false;
        }

        // @todo commit
        return true;
    }

    /**
     * @param UserEntity $user
     *
     * @return array|bool
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function fetchAll(UserEntity $user)
    {
        $prepare = $this->conn->prepare('
          SELECT `idUser`, `id`, `name` FROM dashboards
          WHERE
            idUser = ?
        ');
        $prepare->bindValue(1, $user->id());
        $prepare->execute();

        $data = $prepare->fetchAll();

        if ($data) {
            $dashBoards = [];

            /*
             * @var array
             */
            foreach ($data as $item) {
                $dashBoard = DashBoard::createEntity($user, $item['id'], $item['name']);
                $dashBoards[] = $dashBoard;
            }

            return $dashBoards;
        }

        return false;
    }

    /**
     * @param UserEntity $user
     * @param $idDashboard
     *
     * @return DashboardEntity
     */
    public function fetch(UserEntity $user, $idDashboard)
    {
        $prepare = $this->conn->prepare('
          SELECT `idUser`, `id`, `name` FROM dashboards
          WHERE
            idUser = ? AND id = ?
        ');
        $prepare->bindValue(1, $user->id());
        $prepare->bindValue(2, $idDashboard);
        $prepare->execute();

        $item = $prepare->fetch();

        if ($item) {
            return DashBoard::createEntity($user, $item['id'], $item['name']);
        }

        return false;
    }
}
