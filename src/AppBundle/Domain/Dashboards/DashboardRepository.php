<?php

namespace AppBundle\Domain\Dashboards;

use AppBundle\Domain\Users\UserEntity;

/**
 * Interface DashboardRepository.
 */
interface DashboardRepository
{
    /**
     * @param $conn
     */
    public function setConn($conn);

    /**
     * @param DashboardEntity $dasboard
     *
     * @return mixed
     */
    public function create(DashboardEntity $dasboard);

    /**
     * @param DashboardEntity $dasboard
     *
     * @return mixed
     */
    public function update(DashboardEntity $dasboard);

    /**
     * @param UserEntity $user
     *
     * @return DashboardEntity
     */
    public function fetchAll(UserEntity $user);

    /**
     * @param UserEntity $user
     * @param $idDashboard
     *
     * @return DashboardEntity
     */
    public function fetch(UserEntity $user, $idDashboard);
}
