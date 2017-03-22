<?php

namespace AppBundle\Controller;

use AppBundle\Application\Dashboards\UseCases\FetchDashboardRequest;
use AppBundle\Application\WidgetsInstance\ListWidgetInstanceRequest;
use AppBundle\Domain\Exceptions\CustomException;
use AppBundle\Domain\Exceptions\DashboardException;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ApiDashboardsController.
 */
class ApiDashboardsController extends ApiBaseController
{
    protected $registryTpl = [];

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget", name="get_dashboard_widgets")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Get all instances widgets from dashboard",
     *  method="GET",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when not create"
     *     },
     *     500="Internal error"
     *   }
     * )
     *
     * @param string $idDashboard
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \AppBundle\Domain\Exceptions\UserSessionException
     */
    public function getWidgetsAction($idDashboard)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        try {
            $fetchDashboardUseCase = $this->get('app.application_dashboards_use_cases.fetch_dashboard_use_case');
            $request = new FetchDashboardRequest();
            $request->conn = $this->get('database_connection');
            $request->idDashboard = $idDashboard;
            $request->user = $user;
            $response = $fetchDashboardUseCase->execute($request);

            $dashboard = $response->data;

            if (empty($dashboard)) {
                throw new DashboardException('Cannot retrieve dashboard');
            }
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');

            return $this->handleView($view);
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');

            return $this->handleView($view);
        }

        $listWidgetsInstances = $this->get('app.application_widgets_instance.list_widget_instance_use_case');
        $request = new ListWidgetInstanceRequest();
        $request->conn = $this->get('database_connection');
        $request->dashboard = $dashboard;
        $response = $listWidgetsInstances->execute($request);

        $responseToArray = $response->toArray();

        $this->addTpl($responseToArray);

        $view = $this->view($responseToArray, $response->status())->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * @param array $responseToArray
     *
     * @return mixed
     */
    protected function addTpl(&$responseToArray)
    {
        foreach ($responseToArray as &$responseItem) {
            $idWidget = $responseItem['idWidget'];

            if (!isset($this->registryTpl[$idWidget])) {
                $this->registryTpl[$idWidget] = $this->render('widgets/widget'.$idWidget.'.html.twig')->getContent();
            }

            $responseItem['tpl'] = $this->registryTpl[$idWidget];
        }

        return;
    }
}
