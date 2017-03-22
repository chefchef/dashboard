<?php

namespace AppBundle\Application\WidgetsInstanceData\UseCases;

use AppBundle\Domain\WidgetInstancesData\WidgetInstanceDataRepository;

/**
 * Class FetchWidgetInstanceDataUseCase.
 */
class FetchWidgetInstanceDataUseCase
{
    /**
     * @var WidgetInstanceDataRepository
     */
    private $widgetInstanceDataRepository;

    /**
     * FetchWidgetInstanceDataUseCase constructor.
     *
     * @param WidgetInstanceDataRepository $widgetInstanceDataRepository
     */
    public function __construct(
        WidgetInstanceDataRepository $widgetInstanceDataRepository
    ) {
        $this->widgetInstanceDataRepository = $widgetInstanceDataRepository;
    }

    /**
     * @param FetchWidgetInstanceDataRequest $request
     *
     * @return FetchWidgetInstanceDataResponse
     */
    public function execute(FetchWidgetInstanceDataRequest $request)
    {
        $response = new FetchWidgetInstanceDataResponse();
        try {
            $response->data = $this->widgetInstanceDataRepository->fetch($request->widgetInstance->id());
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the widget instance data';
        }

        return $response;
    }
}
