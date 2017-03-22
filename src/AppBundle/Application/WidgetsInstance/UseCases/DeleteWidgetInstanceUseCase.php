<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Exceptions\WidgetInstanceException;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceRepository;

/**
 * Class DeleteWidgetInstanceUseCase.
 */
class DeleteWidgetInstanceUseCase
{
    private $widgetsRepository;

    /**
     * DeleteWidgetInstanceUseCase constructor.
     *
     * @param WidgetInstanceRepository $widgetRepository
     */
    public function __construct(WidgetInstanceRepository $widgetRepository)
    {
        $this->widgetsRepository = $widgetRepository;
    }

    /**
     * @param DeleteWidgetInstanceRequest $request
     *
     * @return DeleteWidgetInstanceResponse
     */
    public function execute(DeleteWidgetInstanceRequest $request)
    {
        $response = new DeleteWidgetInstanceResponse();
        try {
            if (null === $request->idWidgetInstance) {
                throw new \InvalidArgumentException('Id widget not valid');
            }

            $this->widgetsRepository->setConn($request->conn);

            $res = $this->widgetsRepository->delete(
                $request->dashboard,
                $request->idWidgetInstance
            );

            if (!$res) {
                throw new WidgetInstanceException('Cannot delete widget instance');
            }

            $response->data = $response;
        } catch (\Exception $e) {
            $response->message = 'Cannot delete widget instance';
        }

        return $response;
    }
}
