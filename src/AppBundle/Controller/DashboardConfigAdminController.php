<?php

namespace AppBundle\Controller;

use AppBundle\Domain\Exceptions\DashboardException;
use AppBundle\Domain\Exceptions\UserSessionException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DashboardConfigAdminController.
 */
class DashboardConfigAdminController extends AdminController
{
    /**
     * @Route("/admin/dashboards/config/{id}", name="admin_config_dashboard")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \InvalidArgumentException
     * @throws DashboardException
     * @throws UserSessionException
     */
    public function indexAction(Request $request)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            return $this->redirectToRoute('homepage');
        }

        $idDashboard = $request->get('id');

        return $this->render(
            ':admin:admin_config_dashboard.html.twig',
            ['idDashboard' => $idDashboard, 'userSession' => $userSession]
        );
    }

    /**
     * @Route("/web/dashboards/{idDashboard}", name="show_dashboard")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \InvalidArgumentException
     * @throws DashboardException
     * @throws UserSessionException
     */
    public function widgetAction($idDashboard)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render(':admin:admin_config_show_widgetinstance.html.twig', [
            'idDashboard' => $idDashboard,
            'userSession' => $userSession,
        ]);
    }
}
