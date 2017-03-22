<?php

namespace AppBundle\Controller;

use AppBundle\Domain\Exceptions\UserSessionException;
use AppBundle\Infrastructure\Repository\Users\MysqlUserRepository;
use AppBundle\Resources\Session\UserSession;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class ApiBaseController.
 */
class ApiBaseController extends FOSRestController
{
    /**
     * @return MysqlUserRepository
     */
    protected function initUserRepository()
    {
        /*
         * @var UserRepository
         */
        $userRepository = $this->get('app.infrastructure_user.mysql_user_repository');
        $userRepository->setConn($this->get('database_connection'));

        return $userRepository;
    }

    /**
     * @param $userSession
     *
     * @return \AppBundle\Domain\Users\User|null
     *
     * @throws UserSessionException
     */
    protected function getUserBySession(UserSession $userSession)
    {
        try {
            list($idUser, $email) = $userSession->getUserSession();
            $userRepository = $this->initUserRepository();
            $user = $userRepository->userWithSession($idUser, $email);
        } catch (\Exception $e) {
            throw new UserSessionException('Is not possible to obtain the user session');
        }

        return $user;
    }
}
