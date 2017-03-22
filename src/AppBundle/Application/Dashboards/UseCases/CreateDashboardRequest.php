<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Users\UserEntity;

/**
 * Class CreateDashboardRequest.
 */
class CreateDashboardRequest
{
    /**
     * @var string
     */
    public $name;

    public $conn;

    /**
     * @var UserEntity
     */
    public $user;
}
