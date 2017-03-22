<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class LogoutController.
 */
class LogoutController extends Controller
{
    /**
     * @Route("/logout", name="logout")
     */
    public function indexAction()
    {
        $userSession = $this->get('app.controller_session.user_session');
        $userSession->logout();

        return $this->redirectToRoute('homepage');
    }
}
