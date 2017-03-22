<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Dashboards\DashboardRepository;

/**
 * Class ListDashboardsUseCase.
 */
class ListDashboardsUseCase
{
    private $dashboardRepository;

    /**
     * CreateDashboardUseCase constructor.
     *
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * @param ListDashboardsRequest $request
     *
     * @return ListDashboardsResponse
     */
    public function execute(ListDashboardsRequest $request)
    {
        try {
            $this->dashboardRepository->setConn($request->conn);

            /*
             * @var UserEntity
             */
            $user = $request->getUser();
            $listCollection = $this->dashboardRepository->fetchAll($user);

            $response = new ListDashboardsResponse();
            $response->data = $listCollection;
        } catch (\Exception $e) {
            $response = new ListDashboardsResponse();
            $response->message = 'Cannot retrieve the list of dashboard';
        }

        return $response;
    }
}
