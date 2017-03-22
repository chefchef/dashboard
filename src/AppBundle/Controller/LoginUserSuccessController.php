<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class LoginUserSuccessController.
 */
class LoginUserSuccessController extends Controller
{
    /**
     * @Route("/login-user-success", name="login_user_success")
     *
     * @throws \RuntimeException If session fails to start.
     */
    public function indexAction()
    {
        $userSession = $this->get('app.controller_session.user_session');

        if ($userSession->isLogged()) {
            return $this->redirectToRoute('admin_dashboard');
        } else {
            return $this->redirectToRoute('login');
        }
    }
}
