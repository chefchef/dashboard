<?php

namespace AppBundle\Application\Widgets\UseCases;

use AppBundle\Domain\Widgets\WidgetRepository;

/**
 * Class FetchWidgetUseCase.
 */
class FetchWidgetUseCase
{
    private $widgetsRepository;

    /**
     * FetchWidgetUseCase constructor.
     *
     * @param WidgetRepository $widgetRepository
     */
    public function __construct(WidgetRepository $widgetRepository)
    {
        $this->widgetsRepository = $widgetRepository;
    }

    /**
     * @param FetchWidgetRequest $request
     *
     * @return FetchWidgetResponse
     */
    public function execute(FetchWidgetRequest $request)
    {
        $response = new FetchWidgetResponse();
        try {
            if (null === $request->idWidget) {
                throw new \InvalidArgumentException('Id widget not valid');
            }

            $this->widgetsRepository->setConn($request->conn);

            $widget = $this->widgetsRepository->fetch(
                $request->idWidget
            );

            $response->data = $widget;
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the widget';
        }

        return $response;
    }
}
