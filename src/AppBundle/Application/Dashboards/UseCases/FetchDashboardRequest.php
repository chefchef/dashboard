<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\Users\UserEntity;

/**
 * Class FetchDashboardResponse.
 */
class FetchDashboardRequest extends BaseRequest
{
    public $conn;

    /**
     * @var UserEntity
     */
    public $user;

    /**
     * @var int
     */
    public $idDashboard;
}
