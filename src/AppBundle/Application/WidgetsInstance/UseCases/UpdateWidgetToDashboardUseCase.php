<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Exceptions\WidgetInstanceException;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceRepository;

/**
 * Class UpdateWidgetToDashboardUseCase.
 */
class UpdateWidgetToDashboardUseCase
{
    /**
     * UpdateWidgetToDashboardUseCase constructor.
     *
     * @param WidgetInstanceRepository $widgetRepository
     */
    public function __construct(WidgetInstanceRepository $widgetRepository)
    {
        $this->widgetInstanceRepository = $widgetRepository;
    }

    /**
     * @param UpdateWidgetToDashboardRequest $request
     *
     * @return UpdateWidgetToDashboardResponse
     *
     * @throws WidgetInstanceException
     */
    public function execute(UpdateWidgetToDashboardRequest $request)
    {
        $response = new UpdateWidgetToDashboardResponse();

        try {
            if (null === $request->dashboard->id() || '' === $request->dashboard->id()) {
                throw new \InvalidArgumentException('Id of dashboard is not valid in addwidgetTodashboard');
            }

            $this->widgetInstanceRepository->setConn($request->conn);

            $res = $this->widgetInstanceRepository->update(
                $request->dashboard,
                $request->widgetInstance
            );

            if (!$res) {
                throw new WidgetInstanceException('Cannot update widget instance');
            }

            $response->data = $response;

            if (!$res) {
                throw new WidgetInstanceException('Widget instance not found');
            }

            $response->setStatus(200);
        } catch (\Exception $e) {
            $response->setStatus(500);
            $response->message = 'Update widgets instance is not possible!';
        }

        return $response;
    }
}
