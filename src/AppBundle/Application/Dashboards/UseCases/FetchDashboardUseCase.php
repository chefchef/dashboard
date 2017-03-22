<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Dashboards\DashboardRepository;
use AppBundle\Domain\Users\UserEntity;

/**
 * Class FetchDashboardUseCase.
 */
class FetchDashboardUseCase
{
    private $dashboardRepository;

    /**
     * FetchDashboardUseCase constructor.
     *
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * @param FetchDashboardRequest $request
     *
     * @return FetchDashboardResponse
     */
    public function execute(FetchDashboardRequest $request)
    {
        $response = new FetchDashboardResponse();
        try {
            if (!$request->user instanceof UserEntity) {
                throw new \InvalidArgumentException('User not valid in fetchDashboardUseCase');
            }

            if (null === $request->idDashboard) {
                throw new \InvalidArgumentException('Id dashboard not valid');
            }

            $this->dashboardRepository->setConn($request->conn);

            $dashboard = $this->dashboardRepository->fetch(
                $request->user,
                $request->idDashboard
            );

            $response->data = $dashboard;
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the widget';
        }

        return $response;
    }
}
