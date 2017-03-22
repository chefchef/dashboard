<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\WidgetsInstances\WidgetInstanceRepository;

/**
 * Class FetchWidgetUseCase.
 */
class FetchWidgetInstanceUseCase
{
    private $widgetsRepository;

    /**
     * FetchWidgetInstanceUseCase constructor.
     *
     * @param WidgetInstanceRepository $widgetRepository
     */
    public function __construct(WidgetInstanceRepository $widgetRepository)
    {
        $this->widgetsRepository = $widgetRepository;
    }

    /**
     * @param FetchWidgetInstanceRequest $request
     *
     * @return FetchWidgetInstanceResponse
     */
    public function execute(FetchWidgetInstanceRequest $request)
    {
        $response = new FetchWidgetInstanceResponse();
        try {
            if (null === $request->idWidgetInstance) {
                throw new \InvalidArgumentException('Id widget not valid');
            }

            $this->widgetsRepository->setConn($request->conn);

            $widgetInstance = $this->widgetsRepository->fetch(
                $request->dashboard,
                $request->idWidgetInstance
            );

            $response->data = $widgetInstance;
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the widget instance';
        }

        return $response;
    }
}
