<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\Dashboards\DashboardEntity;

/**
 * Class ListDashboardsResponse.
 */
class ListDashboardsResponse extends BaseResponse
{
    public $data;

    /**
     * @return mixed
     */
    public function toArray()
    {
        $res = [];

        /*
         * @var DashboardEntity[]
         */
        $dashboardData = $this->data;

        foreach ($dashboardData as $dashboard) {
            $res[] = $dashboard->toArray();
        }

        return $res;
    }
}
