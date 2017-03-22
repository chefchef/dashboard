<?php

namespace AppBundle\Domain\Users;

/**
 * Interface UserEntity.
 */
interface UserEntity
{
    public function id();

    public function email();

    public function password();

    public function isValid();

    /**
     * @param $user
     * @param $name
     *
     * @return mixed
     */
    public static function create($user, $name);

    /**
     * @param $email
     * @param $idUser
     *
     * @return mixed
     */
    public static function createEntity($email, $idUser);

    /**
     * @return mixed
     */
    public static function createFormEntity();
}
