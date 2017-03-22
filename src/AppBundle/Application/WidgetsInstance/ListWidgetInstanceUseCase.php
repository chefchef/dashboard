<?php

namespace AppBundle\Application\WidgetsInstance;

use AppBundle\Domain\WidgetsInstances\WidgetInstanceRepository;

/**
 * Class ListWidgetInstanceUseCase.
 */
class ListWidgetInstanceUseCase
{
    private $widgetsInstanceRepository;

    /**
     * ListWidgetsUseCase constructor.
     *
     * @param WidgetInstanceRepository $widgetInstanceRepository
     */
    public function __construct(WidgetInstanceRepository $widgetInstanceRepository)
    {
        $this->widgetsInstanceRepository = $widgetInstanceRepository;
    }

    /**
     * @param ListWidgetInstanceRequest $request
     *
     * @return ListWidgetInstanceResponse
     */
    public function execute(ListWidgetInstanceRequest $request)
    {
        $response = new ListWidgetInstanceResponse();

        try {
            $this->widgetsInstanceRepository->setConn($request->conn);

            $listCollection = $this->widgetsInstanceRepository->fetchAll($request->dashboard);

            $response->data = $listCollection;
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the list of instance widgets in dashboard';
        }

        return $response;
    }
}
