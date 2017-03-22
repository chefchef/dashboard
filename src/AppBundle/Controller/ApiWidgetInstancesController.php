<?php

namespace AppBundle\Controller;

use AppBundle\Application\Dashboards\UseCases\AddWidgetToDashboardRequest;
use AppBundle\Application\Dashboards\UseCases\FetchDashboardRequest;
use AppBundle\Application\Widgets\UseCases\FetchWidgetRequest;
use AppBundle\Application\WidgetsInstance\UseCases\DeleteWidgetInstanceRequest;
use AppBundle\Application\WidgetsInstance\UseCases\FetchWidgetInstanceRequest;
use AppBundle\Application\WidgetsInstance\UseCases\UpdateWidgetToDashboardRequest;
use AppBundle\Application\WidgetsInstanceData\UseCases\FetchWidgetInstanceDataRequest;
use AppBundle\Application\WidgetsInstanceData\UseCases\GenerateWidgetInstanceDataRequest;
use AppBundle\Domain\Dashboards\DashBoard;
use AppBundle\Domain\Events\Traits\EventsHelper;
use AppBundle\Domain\Exceptions\CustomException;
use AppBundle\Domain\Exceptions\DashboardException;
use AppBundle\Domain\Exceptions\WidgetException;
use AppBundle\Domain\Exceptions\WidgetInstanceDataException;
use AppBundle\Domain\Exceptions\WidgetInstanceException;
use AppBundle\Domain\Users\User;
use AppBundle\Domain\WidgetsInstances\WidgetInstanceEntity;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WidgetController.
 */
class ApiWidgetInstancesController extends ApiBaseController
{
    use EventsHelper;

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget", name="Post_widget_dashboard")
     * @Method({"POST"})
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new instance of widget",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidget", "dataType"="string", "required"=true, "description"="widget id"}
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
     * @param Request $request
     * @param $idDashboard
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \AppBundle\Domain\Exceptions\UserSessionException
     * @throws \InvalidArgumentException
     */
    public function postWidgetInstanceAction(Request $request, $idDashboard)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        $idWidget = $request->request->getInt('idWidget');

        try {
            $dashboard = $this->fetchDashboard($idDashboard, $user);

            /*
             * @var FetchWidgetUseCase
             */
            $fetchWidgetUseCase = $this->get('app.application_widgets_use_cases.fetch_widget_use_case');
            $fetchWidgetRequest = new FetchWidgetRequest();
            $fetchWidgetRequest->conn = $this->get('database_connection');
            $fetchWidgetRequest->idWidget = $idWidget;

            $response = $fetchWidgetUseCase->execute($fetchWidgetRequest);

            $widget = $response->data;

            if (empty($widget)) {
                throw new WidgetException('Cannot retrieve widget');
            }
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');

            return $this->handleView($view);
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');

            return $this->handleView($view);
        }

        /*
         * @var AddWidgetToDashboardUseCase
         */
        $addWidgetUseCase = $this->get('app.application_dashboards_use_cases.add_widget_to_dashboard_use_case');
        $request = new AddWidgetToDashboardRequest();
        $request->conn = $this->get('database_connection');
        $request->dashboard = $dashboard;
        $request->widget = $widget;

        $response = $addWidgetUseCase->execute($request);

        $this->eventReload($response);

        $view = $this->view($response->toArray(), $response->status())->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget/{idWidgetInstance}", name="get_widgetinstance_in_dashboard")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Return a widgetinstance entity in dashboard",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidgetInstance", "dataType"="string", "required"=true, "description"="widget id"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget instance is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string $idDashboard      Dashboard identifier
     * @param string $idWidgetInstance Widget instance identifier
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWidgetIdAction($idDashboard, $idWidgetInstance)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        try {
            $dashboard = $this->fetchDashboard($idDashboard, $user);

            $response = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);

            $view = $this->view($response->toArray(), $response->status())->setFormat('json');
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget/{idWidgetInstance}", name="delete_widgetinstance_dashboard")
     * @Method({"DELETE"})
     * @ApiDoc(
     *  resource=true,
     *  description="Delete a widgetinstance entity in dashboard",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidgetInstance", "dataType"="string", "required"=true, "description"="widget id"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget instance is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string $idDashboard      Dashboard identifier
     * @param string $idWidgetInstance Widget instance identifier
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteWidgetInstance($idDashboard, $idWidgetInstance)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        try {
            $dashboard = $this->fetchDashboard($idDashboard, $user);

            $widgetInstanceResponse = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);

            if (empty($widgetInstanceResponse->data)) {
                throw new WidgetInstanceException('Widget instance not found');
            }

            $request = new DeleteWidgetInstanceRequest();
            $request->conn = $this->get('database_connection');
            $request->idWidgetInstance = $idWidgetInstance;
            $request->dashboard = $dashboard;
            $fetchWidgetInstanceUseCase =
                $this->get('app.application_widgets_instance_use_cases.delete_widget_instance_use_case');
            $response = $fetchWidgetInstanceUseCase->execute($request);

            $this->eventReload($response);

            $view = $this->view($response->toArray(), $response->status())->setFormat('json');
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget/{idWidgetInstance}/size", name="update_widgetinstance_size")
     * @Method({"PATCH"})
     * @ApiDoc(
     *  resource=true,
     *  description="Update a widgetinstance entity size",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidgetInstance", "dataType"="string", "required"=true, "description"="widget id"},
     *      {"name"="sizeX", "dataType"="int", "required"=true, "description"="Size X in pixels"},
     *      {"name"="sizeY", "dataType"="int", "required"=true, "description"="Size Y in pixels"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget instance is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string  $idDashboard      Dashboard identifier
     * @param string  $idWidgetInstance Widget instance identifier
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \AppBundle\Domain\Exceptions\UserSessionException
     */
    public function patchWidgetInstanceUpdateSize($idDashboard, $idWidgetInstance, Request $request)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        $sizeX = $request->request->getInt('sizeX');
        $sizeY = $request->request->getInt('sizeY');

        try {
            $dashboard = $this->fetchDashboard($idDashboard, $user);

            $widgetInstanceResponse = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);

            if (empty($widgetInstanceResponse->data)) {
                throw new WidgetInstanceException('Widget instance not found');
            }
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');

            return $this->handleView($view);
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');

            return $this->handleView($view);
        }

        $widgetInstance = $widgetInstanceResponse->data;
        $widgetInstance->setSize($sizeX, $sizeY);

        /*
         * @var UpdateWidgetToDashboardUseCase
         */
        $addWidgetUseCase =
            $this->get('app.application_widgets_instance_use_cases.update_widget_to_dashboard_use_case');
        $request = new UpdateWidgetToDashboardRequest();
        $request->conn = $this->get('database_connection');
        $request->dashboard = $dashboard;
        $request->widgetInstance = $widgetInstance;

        $response = $addWidgetUseCase->execute($request);

        $view = $this->view($response->toArray(), $response->status())->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget/{idWidgetInstance}/position",
     *     name="update_widgetinstance_position")
     * @Method({"PATCH"})
     * @ApiDoc(
     *  resource=true,
     *  description="Update a widgetinstance entity position",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidgetInstance", "dataType"="string", "required"=true, "description"="widget id"},
     *      {"name"="positionX", "dataType"="int", "required"=true, "description"="Position relative LEFT in pixels"},
     *      {"name"="positionY", "dataType"="int", "required"=true, "description"="Position relative TOP in pixels"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget instance is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string  $idDashboard      Dashboard identifier
     * @param string  $idWidgetInstance Widget instance identifier
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \AppBundle\Domain\Exceptions\UserSessionException
     */
    public function patchWidgetInstanceUpdatePosition($idDashboard, $idWidgetInstance, Request $request)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        $positionX = $request->request->getInt('positionX');
        $positionY = $request->request->getInt('positionY');

        try {
            $dashboard = $this->fetchDashboard($idDashboard, $user);

            $widgetInstanceResponse = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);

            if (empty($widgetInstanceResponse->data)) {
                throw new WidgetInstanceException('Widget instance not found');
            }
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');

            return $this->handleView($view);
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');

            return $this->handleView($view);
        }

        $widgetInstance = $widgetInstanceResponse->data;
        $widgetInstance->setPosition($positionX, $positionY);

        /*
         * @var UpdateWidgetToDashboardUseCase
         */
        $addWidgetUseCase =
            $this->get('app.application_widgets_instance_use_cases.update_widget_to_dashboard_use_case');
        $request = new UpdateWidgetToDashboardRequest();
        $request->conn = $this->get('database_connection');
        $request->dashboard = $dashboard;
        $request->widgetInstance = $widgetInstance;

        $response = $addWidgetUseCase->execute($request);

        $view = $this->view($response->toArray(), $response->status())->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget/{idWidgetInstance}/data", name="get_widgetinstancedata")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Return a real time data for widgetinstance entity",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidgetInstance", "dataType"="string", "required"=true, "description"="widget id"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget instance data is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string $idDashboard      Dashboard identifier
     * @param string $idWidgetInstance Widget instance identifier
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWidgetDataAction($idDashboard, $idWidgetInstance)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        try {
            $dashboard = $this->fetchDashboard($idDashboard, $user);

            if (empty($dashboard)) {
                throw new DashboardException('Dashboard not found');
            }

            $widgetInstanceResponse = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);

            if (empty($widgetInstanceResponse->data)) {
                throw new WidgetInstanceException('Widget instance not found');
            }

            $response = $this->fetchWidgetInstanceData($widgetInstanceResponse->data);
            $this->eventGenerateData($response, $idDashboard, $idWidgetInstance);

            if (null === $response->data) {
                throw new WidgetInstanceDataException('Widget data not found');
            }

            $responseArray = $response->toArray();

            $responseWidgetInstance = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);
            $responseWidgetInstanceArray = $responseWidgetInstance->toArrayInfo();

            $responseArray = array_merge($responseArray, $responseWidgetInstanceArray);

            $view = $this->view($responseArray, $response->status())->setFormat('json');
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/dashboard/{idDashboard}/instanceWidget/{idWidgetInstance}/generate", name="gen_widgetinstancedata")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Generate new information for the widget instance and send event to notify",
     *  parameters={
     *      {"name"="idDashboard", "dataType"="string", "required"=true, "description"="dashboard id"},
     *      {"name"="idWidgetInstance", "dataType"="string", "required"=true, "description"="widget id"}
     *  },
     *  statusCodes={
     *     200="Returned when successful",
     *     404={
     *          "Returned when widget instance data is not found"
     *     },
     *     500="Internal error"
     *   }
     * ),
     *
     * @param string $idDashboard      Dashboard identifier
     * @param string $idWidgetInstance Widget instance identifier
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateWidgetsAction($idDashboard, $idWidgetInstance)
    {
        try {
            $dashboard = $this->createDashboard($idDashboard);

            if (empty($dashboard)) {
                throw new DashboardException('Dashboard not found');
            }

            $widgetInstanceResponse = $this->fetchWidgetInstance($idWidgetInstance, $dashboard);

            if (empty($widgetInstanceResponse->data)) {
                throw new WidgetInstanceException('Widget instance not found');
            }

            $usecase = $this->get(
                'app.application_widgets_instance_data_use_cases.generate_widget_instance_data_use_case'
            );
            $request = new GenerateWidgetInstanceDataRequest();
            $request->widgetInstance = $widgetInstanceResponse->data;
            $response = $usecase->execute($request);

            if (!empty($response->data)) {
                $this->eventRefreshData($response, $idWidgetInstance);
            }

            $view = $this->view([], $response->status())->setFormat('json');
        } catch (CustomException $e) {
            $view = $this->view(['message' => $e->getMessage()], 404)->setFormat('json');
        } catch (\Exception $e) {
            $view = $this->view(['message' => 'Internal error'], 500)->setFormat('json');
        }

        return $this->handleView($view);
    }

    /**
     * @param $idDashboard
     * @param $user
     *
     * @return \AppBundle\Domain\Dashboards\DashboardEntity
     *
     * @throws DashboardException
     */
    protected function fetchDashboard($idDashboard, $user)
    {
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

        return $dashboard;
    }

    /**
     * @param $idWidgetInstance
     * @param $dashboard
     *
     * @return \AppBundle\Application\WidgetsInstance\UseCases\FetchWidgetInstanceResponse
     */
    protected function fetchWidgetInstance($idWidgetInstance, $dashboard)
    {
        $request = new FetchWidgetInstanceRequest();
        $request->conn = $this->get('database_connection');
        $request->idWidgetInstance = $idWidgetInstance;
        $request->dashboard = $dashboard;
        $fetchWidgetInstanceUseCase =
            $this->get('app.application_widgets_instance_use_cases.fetch_widget_instance_use_case');

        return $fetchWidgetInstanceUseCase->execute($request);
    }

    /**
     * @param WidgetInstanceEntity $widgetInstance
     *
     * @return \AppBundle\Application\WidgetsInstanceData\UseCases\FetchWidgetInstanceDataResponse
     */
    protected function fetchWidgetInstanceData(WidgetInstanceEntity $widgetInstance)
    {
        $request = new FetchWidgetInstanceDataRequest();
        $request->widgetInstance = $widgetInstance;

        $fetchWidgetInstanceDataUseCase =
            $this->get('app.application_widgets_instance_data_use_cases.fetch_widget_instance_data_use_case');

        return $fetchWidgetInstanceDataUseCase->execute($request);
    }

    /**
     * @param $idDashboard
     *
     * @return DashBoard
     */
    private function createDashboard($idDashboard)
    {
        $user = User::create('robot@dashboarduoc.net', 'private');

        return DashBoard::createEntity($user, $idDashboard, '');
    }
}
