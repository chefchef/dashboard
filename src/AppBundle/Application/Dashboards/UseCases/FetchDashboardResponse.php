<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\Dashboards\DashboardEntity;

/**
 * Class FetchDashboardResponse.
 */
class FetchDashboardResponse extends BaseResponse
{
    /**
     * @var DashboardEntity
     */
    public $data;

    /**
     * @return mixed
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}
