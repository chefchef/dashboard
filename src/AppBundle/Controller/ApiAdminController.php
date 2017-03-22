<?php

namespace AppBundle\Controller;

use AppBundle\Application\Dashboards\UseCases\ListDashboardsRequest;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ApiDashboardsController.
 */
class ApiAdminController extends ApiBaseController
{
    /**
     * @Route("/api/user/{idUser}/dashboards", name="list_dashboards_user")
     * @Method({"GET"})
     * @ApiDoc(
     *  resource=true,
     *  description="Return a diggest of dashboards and other information of the user",
     *  method="GET",
     *  parameters={
     *      {"name"="idUser", "dataType"="string", "required"=true, "description"="user id"},
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
     * @param string $idUser
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \AppBundle\Domain\Exceptions\UserSessionException
     */
    public function getInfoAdmin($idUser)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $user = $this->getUserBySession($userSession);

        if ($user->id() !== $idUser) {
            $view = $this->view([], 401);

            return $this->handleView($view);
        }

        $request = new ListDashboardsRequest();
        $request->setUser($user);
        $request->conn = $this->get('database_connection');
        $listDashboard = $this->get('app.model_dashboards_use_cases.list_dashboard_use_case');
        $response = $listDashboard->execute($request);

        $view = $this->view($response->toArray(), 200)->setFormat('json');

        return $this->handleView($view);
    }
}
