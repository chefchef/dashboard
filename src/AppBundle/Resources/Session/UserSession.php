<?php

namespace AppBundle\Resources\Session;

use AppBundle\Application\Users\UseCases\LoginUserResponse;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class UserSession.
 */
class UserSession
{
    /**
     * UserSession constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param LoginUserResponse $loginUserResponse
     */
    public function initUserSession(LoginUserResponse $loginUserResponse)
    {
        $this->session->set('user.id', $loginUserResponse->id);
        $this->session->set('user.email', $loginUserResponse->email);
    }

    /**
     * @return array
     */
    public function getUserSession()
    {
        $id = $this->session->get('user.id');
        $email = $this->session->get('user.email');

        return [$id, $email];
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->session->get('user.email');
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->session->get('user.id');
    }

    public function logout()
    {
        $this->session->clear();
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        return null !== $this->session->get('user.id') && null !== $this->session->get('user.email');
    }
}
