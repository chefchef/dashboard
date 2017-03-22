<?php

namespace AppBundle\Controller;

use AppBundle\Application\Widgets\UseCases\FetchWidgetRequest;
use AppBundle\Application\Widgets\UseCases\ListWidgetsRequest;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class WidgetController.
 */
class ApiWidgetController extends ApiBaseController
{
    /**
     * @Route("/api/widgets", name="list_widgets")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of widgets availables",
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when something else is not found"
     *     },
     *     500="Internal error"
     *   }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWidgetAction()
    {
        /*
         * @var ListWidgetsUseCase
         */
        $listWidgets = $this->get('app.application_dashboards_use_cases.list_widgets_use_case');
        $requestList = new ListWidgetsRequest();
        $requestList->conn = $this->get('database_connection');
        $responseList = $listWidgets->execute($requestList);

        $view = $this->view($responseList->toArray(), $responseList->status())->setFormat('json');
        // @todo autodetect format

        return $this->handleView($view);
    }

    /**
     * @Route("/api/widgets/{idWidget}", name="fetch_widget")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Return a widget entity",
     *  parameters={
     *      {"name"="idWidget", "dataType"="string", "required"=true, "description"="widget id"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget id is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string $idWidget Widget identifier
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWidgetIdAction($idWidget)
    {
        /*
         * @var FetchWidgetUseCase
         */
        $fetchWidgetUseCase = $this->get('app.application_widgets_use_cases.fetch_widget_use_case');
        $fetchWidgetRequest = new FetchWidgetRequest();
        $fetchWidgetRequest->conn = $this->get('database_connection');
        $fetchWidgetRequest->idWidget = $idWidget;

        $response = $fetchWidgetUseCase->execute($fetchWidgetRequest);

        $view = $this->view($response->toArray(), $response->status())->setFormat('json');

        return $this->handleView($view);
    }
}
