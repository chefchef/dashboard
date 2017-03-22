<?php

namespace AppBundle\Domain\Users;

/**
 * Interface UserRepository.
 */
interface UserRepository
{
    /**
     * @param $conn
     */
    public function setConn($conn);

    /**
     * @param UserEntity $user
     *
     * @return mixed
     */
    public function register(UserEntity $user);

    /**
     * @param $userId
     * @param UserEntity $user
     *
     * @return mixed
     */
    public function update($userId, UserEntity $user);

    /**
     * @param $email
     * @param $password
     *
     * @return mixed
     */
    public function userWithCredentials($email, $password);
}
