<?php

namespace AppBundle\Controller;

use AppBundle\Application\Dashboards\UseCases\CreateDashboardRequest;
use AppBundle\Domain\Dashboards\DashBoard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DashboardAdminController.
 */
class DashboardAdminController extends AdminController
{
    /**
     * @Route("/admin/", name="admin_dashboard")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $userSession = $this->get('app.controller_session.user_session');
        if (!$userSession->isLogged()) {
            return $this->redirectToRoute('homepage');
        }

        $user = $this->getUserBySession($userSession);

        $form = $this->createFormBuilder(DashBoard::createFormEntity($user))
            ->add('name', 'text')
            ->add('save', 'submit', ['label' => 'Create new dashboard'])
            ->getForm();

        $form->handleRequest($request);

        $message = '';
        if ($form->isValid()) {
            $name = $form->get('name')->getData();

            $request = new CreateDashboardRequest();
            $request->name = $name;
            $request->user = $user;
            $request->conn = $this->get('database_connection');

            $dashboardUseCase = $this->get('app.model_dashboards_use_cases.create_dashboard_use_case');
            $response = $dashboardUseCase->execute($request);
            $message = $response->message;
        }

        return $this->render(':admin:admin_dashboard.html.twig', [
            'form' => $form->createView(), 'message' => $message,
            'userSession' => $userSession,
            'stats' => [
                'numDashboards' => '',
                'numWidgets' => '',
            ],
        ]);
    }
}
