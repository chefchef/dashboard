<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Dashboards\DashboardRepository;
use AppBundle\Domain\Exceptions\DashboardException;
use AppBundle\Domain\Users\UserEntity;
use AppBundle\Domain\Dashboards\DashBoard;

/**
 * Class CreateDashboardUseCase.
 */
class CreateDashboardUseCase
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
     * @param CreateDashboardRequest $request
     *
     * @return CreateDashboardResponse
     *
     * @throws \InvalidArgumentException
     * @throws DashboardException
     */
    public function execute(CreateDashboardRequest $request)
    {
        $response = new CreateDashboardResponse();
        try {
            if (!$request->user instanceof UserEntity) {
                throw new \InvalidArgumentException('User not valid in createdashboardUsecase');
            }

            $request->name = trim($request->name);

            if (null === $request->name || '' === $request->name) {
                throw new \InvalidArgumentException('Name of dashboard not valid in createdashboardUsecase');
            }

            $dashboard = DashBoard::create($request->user, $request->name);

            $this->dashboardRepository->setConn($request->conn);
            $res = $this->dashboardRepository->create($dashboard);

            if (!$res) {
                throw new DashboardException('Dashboard not create');
            }
        } catch (\Exception $e) {
            $response->message = 'Cannot create the dashboard '.$request->name;
        }

        return $response;
    }
}
