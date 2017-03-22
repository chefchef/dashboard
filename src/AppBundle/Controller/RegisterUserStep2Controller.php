<?php

namespace AppBundle\Controller;

use AppBundle\Application\Users\UseCases\LoginUserResponse;
use AppBundle\Application\Users\UseCases\RegisterUserRequest;
use AppBundle\Domain\Users\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegisterUserStep2Controller.
 */
class RegisterUserStep2Controller extends Controller
{
    /**
     * @Route("/register-user-submit", name="register_user_submit")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $userSession = $this->get('app.controller_session.user_session');

        if ($userSession->isLogged()) {
            return $this->redirectToRoute('admin_dashboard');
        }

        /*
         * @var UserRepository
         */
        $userRepository = $this->get('app.infrastructure_user.mysql_user_repository');
        $userRepository->setConn($this->get('database_connection'));

        $form = $this->createFormBuilder(User::createFormEntity())
            ->add('email', 'text')
            ->add('password', 'password')
            ->add('repassword', 'password', ['label' => 'Retype the password'])
            ->add('save', 'submit', ['label' => 'Sign In'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $registerUseCase = $this->get('app.model_users_use_cases.register_user_use_case');
                $registerUserRequest = new RegisterUserRequest();
                $registerUserRequest->email = $form->get('email')->getData();
                $registerUserRequest->password = $form->get('password')->getData();
                $registerUserRequest->repassword = $form->get('repassword')->getData();
                $responseRegister = $registerUseCase->execute($registerUserRequest);
            } catch (\Exception $e) {
                $responseRegister = null;
            }

            $response = new LoginUserResponse();
            if (isset($responseRegister->id)) {
                $response->id = $responseRegister->id;
                $response->email = $responseRegister->email;

                $userSession = $this->get('app.controller_session.user_session');
                $userSession->initUserSession($response);

                if ($userSession->isLogged()) {
                    return $this->redirectToRoute('admin_dashboard');
                }
            }
        }

        $errors = [];
        if (isset($responseRegister)) {
            $errors = $responseRegister->getErrors();
        }

        return $this->render(
            'default/registeruser.html.twig',
            ['form' => $form->createView(), 'userSession' => $userSession, 'errors' => $errors]
        );
    }
}
