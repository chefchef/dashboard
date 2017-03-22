<?php

namespace AppBundle\Application\WidgetsInstanceData\UseCases;

use AppBundle\Domain\WidgetInstancesData\WidgetInstanceDataFactory;
use AppBundle\Domain\WidgetInstancesData\WidgetInstanceDataRepository;

/**
 * Class FetchWidgetInstanceDataUseCase.
 */
class GenerateWidgetInstanceDataUseCase
{
    /**
     * @var WidgetInstanceDataFactory
     */
    private $widgetInstanceDataFactory;

    /**
     * @var WidgetInstanceDataRepository
     */
    private $widgetInstanceDataRepository;

    /**
     * GenerateWidgetInstanceDataUseCase constructor.
     *
     * @param WidgetInstanceDataFactory    $widgetInstanceDataFactory
     * @param WidgetInstanceDataRepository $widgetInstanceDataRepository
     */
    public function __construct(
        WidgetInstanceDataFactory $widgetInstanceDataFactory,
        WidgetInstanceDataRepository $widgetInstanceDataRepository
    ) {
        $this->widgetInstanceDataFactory = $widgetInstanceDataFactory;
        $this->widgetInstanceDataRepository = $widgetInstanceDataRepository;
    }

    /**
     * @param GenerateWidgetInstanceDataRequest $request
     *
     * @return FetchWidgetInstanceDataResponse
     */
    public function execute(GenerateWidgetInstanceDataRequest $request)
    {
        $response = new GenerateWidgetInstanceDataResponse();
        try {
            $dataInstance = $this->widgetInstanceDataFactory->getInstance($request->widgetInstance->idWidget());

            $response->data = $dataInstance->generateData();

            $this->widgetInstanceDataRepository->create($request->widgetInstance->id(), $response->data);
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the widget instance data';
        }

        return $response;
    }
}
