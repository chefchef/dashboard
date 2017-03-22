<?php

namespace AppBundle\Domain\Users;

/**
 * Class UserPasswordGenerator.
 */
class UserPasswordGenerator
{
    const SALT = 'adsdgasd5asd4asdafgsdas5dasdasdawedwewqerqwrqwerewrwrewrwerwer';

    /**
     * @param $password
     *
     * @return bool|string
     */
    public static function generate($password)
    {
        return password_hash($password, CRYPT_BLOWFISH, ['salt' => self::SALT]);
    }
}
