<?php

namespace AppBundle\Tests\Model\Dashboards\UseCases;

use AppBundle\Application\Dashboards\UseCases\ListDashboardsRequest;
use AppBundle\Application\Dashboards\UseCases\ListDashboardsUseCase;
use AppBundle\Domain\Dashboards\DashboardRepository;
use AppBundle\Domain\Users\UserEntity;

/**
 * Class ListDashboardsUseCaseTest.
 */
class ListDashboardsUseCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ListDashboardsUseCase
     */
    private $sut;

    public function testListDashboardHappyPath()
    {
        $result = ['res'];
        $user = $this->initUser();
        $conn = $this->iniConnection();
        $dashboardRepository = $this->initRepositoryStub();
        $dashboardRepository->setConn($conn)->willReturn(null);
        $dashboardRepository->fetchAll($user->reveal())->willReturn($result);
        $this->initSut($dashboardRepository);

        $request = new ListDashboardsRequest();
        $request->setUser($user->reveal());
        $request->conn = $conn;
        $response = $this->sut->execute($request);

        $this->assertSame(200, $response->status());
        $this->assertNull($response->message);
        $this->assertSame($result, $response->data);
    }

    public function testListDashboardErrorPath()
    {
        $user = $this->initUser();
        $conn = $this->iniConnection();
        $dashboardRepository = $this->initRepositoryStub();
        $dashboardRepository->setConn($conn)->willReturn(null);
        $dashboardRepository->fetchAll($user->reveal())->willThrow(new \Exception(''));
        $this->initSut($dashboardRepository);

        $request = new ListDashboardsRequest();
        $request->setUser($user->reveal());
        $request->conn = $conn;
        $response = $this->sut->execute($request);

        $this->assertSame(500, $response->status());
        $this->assertSame('Cannot retrieve the list of dashboard', $response->message);
        $this->assertNull($response->data);
    }

    /**
     * @param $dashboardRepository
     */
    protected function initSut($dashboardRepository)
    {
        $this->sut = new ListDashboardsUseCase($dashboardRepository->reveal());
    }

    /**
     * @return UserEntity
     */
    protected function initUser()
    {
        return $this->prophesize(UserEntity::class);
    }

    /**
     * @return UserEntity
     */
    protected function iniConnection()
    {
        return 'connection';
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function initRepositoryStub()
    {
        return $this->prophesize(DashboardRepository::class);
    }
}
