<?php

namespace AppBundle\Application\Widgets\UseCases;

use AppBundle\Domain\Widgets\WidgetRepository;

/**
 * Class ListWidgetsUseCase.
 */
class ListWidgetsUseCase
{
    private $widgetsRepository;

    /**
     * ListWidgetsUseCase constructor.
     *
     * @param WidgetRepository $widgetRepository
     */
    public function __construct(WidgetRepository $widgetRepository)
    {
        $this->widgetsRepository = $widgetRepository;
    }

    /**
     * @param ListWidgetsRequest $request
     *
     * @return ListWidgetsResponse
     */
    public function execute(ListWidgetsRequest $request)
    {
        $response = new ListWidgetsResponse();
        try {
            $this->widgetsRepository->setConn($request->conn);

            $listCollection = $this->widgetsRepository->fetchAll();

            $response->data = $listCollection;
        } catch (\Exception $e) {
            $response->message = 'Cannot retrieve the list of widgets';
        }

        return $response;
    }
}
