<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Dashboards\DashboardRepository;
use AppBundle\Domain\Exceptions\WidgetInstanceException;
use AppBundle\Domain\WidgetsInstances\WidgetInstance;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceRepository;

/**
 * Class AddWidgetToDashboardUseCase.
 */
class AddWidgetToDashboardUseCase
{
    private $dashboardRepository;

    /**
     * AddWidgetToDashboardUseCase constructor.
     *
     * @param DashboardRepository      $dashboardRepository
     * @param WidgetInstanceRepository $widgetRepository
     */
    public function __construct(DashboardRepository $dashboardRepository, WidgetInstanceRepository $widgetRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->widgetInstanceRepository = $widgetRepository;
    }

    /**
     * @param AddWidgetToDashboardRequest $request
     *
     * @return AddWidgetToDashboardResponse
     */
    public function execute(AddWidgetToDashboardRequest $request)
    {
        $response = new AddWidgetToDashboardResponse();

        try {
            $request->name = trim($request->name);

            if (null === $request->dashboard->id() || '' === $request->dashboard->id()) {
                throw new \InvalidArgumentException('Id of dashboard is not valid in addwidgetTodashboard');
            }

            $this->widgetInstanceRepository->setConn($request->conn);

            $widget = WidgetInstance::create($request->widget->id(), $request->dashboard->id(), $request->name);
            $res = $this->widgetInstanceRepository->create($widget);

            if (!$res) {
                throw new WidgetInstanceException('Widget instance not found');
            }
            $response->data = ['id' => $widget->id()];
        } catch (\Exception $e) {
            $response->message = 'Add widgets to dashboard ko!';
        }

        return $response;
    }
}
