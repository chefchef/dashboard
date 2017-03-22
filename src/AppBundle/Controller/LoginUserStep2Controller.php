<?php

namespace AppBundle\Controller;

use AppBundle\Application\Users\UseCases\LoginUserRequest;
use AppBundle\Application\Users\UseCases\LoginUserUseCase;
use AppBundle\Domain\Users\User;
use AppBundle\Domain\Users\UserPasswordGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegisterUserController.
 */
class LoginUserStep2Controller extends Controller
{
    /**
     * @Route("/login", name="login_user_submit")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
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
            ->add('save', 'submit', ['label' => 'Login'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            /**
             * @var LoginUserUseCase
             */
            $loginUseCase = $this->get('app.model_users_use_cases.login_user_use_case');
            $loginUserRequest = new LoginUserRequest();
            $loginUserRequest->email = $form->get('email')->getData();
            $loginUserRequest->password = UserPasswordGenerator::generate($form->get('password')->getData());

            $response = $loginUseCase->execute($loginUserRequest);

            if (null !== $response->id) {
                $userSession = $this->get('app.controller_session.user_session');
                $userSession->initUserSession($response);

                return $this->redirectToRoute('login_user_success');
            }
        }

        $errors = [];
        if (isset($response)) {
            $errors = $response->getErrors();
        }

        return $this->render(
            'default/loginuser.html.twig',
            ['form' => $form->createView(), 'userSession' => $userSession, 'errors' => $errors]
        );
    }
}
