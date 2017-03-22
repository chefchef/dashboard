<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Core\BaseRequest;
use AppBundle\Domain\Users\UserEntity;

/**
 * Class ListDashboardsRequest.
 */
class ListDashboardsRequest extends BaseRequest
{
    /**
     * @var UserEntity
     */
    private $user;

    public $conn;

    /**
     * @return UserEntity
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserEntity $user
     */
    public function setUser(UserEntity $user)
    {
        $this->user = $user;
    }
}
