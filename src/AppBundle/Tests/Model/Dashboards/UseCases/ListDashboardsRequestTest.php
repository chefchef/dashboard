<?php

namespace AppBundle\Tests\Model\Dashboards\UseCases;

use AppBundle\Application\Dashboards\UseCases\ListDashboardsRequest;
use AppBundle\Domain\Users\User;

/**
 * Class ListDashboardsRequestTest.
 */
class ListDashboardsRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRequestWithUser()
    {
        $user = User::createEntity('edu@uoc.com', 1);
        $request = new ListDashboardsRequest();
        $request->setUser($user);

        $this->assertSame($user, $request->getUser());
        $this->assertInstanceOf(ListDashboardsRequest::class, $request);
    }
}
