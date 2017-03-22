<?php

namespace AppBundle\Infrastructure\Repository\Users;

use AppBundle\Domain\Users\User;
use AppBundle\Domain\Users\UserEntity;
use AppBundle\Domain\Users\UserRepository;

/**
 * Class InMemoryUserRepository.
 */
class MysqlUserRepository implements UserRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $conn;

    /**
     * @param $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param UserEntity $user
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function register(UserEntity $user)
    {
        $prepare = $this->conn->prepare('
          INSERT INTO users (`idUser`, `email`, `passw`) VALUES (?, ?, ?)
        ');
        $prepare->bindValue(1, $user->id());
        $prepare->bindValue(2, $user->email());
        $prepare->bindValue(3, $user->password());

        return $prepare->execute();
    }

    /**
     * @param $userId
     * @param UserEntity $user
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update($userId, UserEntity $user)
    {
        $prepare = $this->conn->prepare('
          UPDATE users SET (`email`, `passw`) VALUES (?, ?) WHERE idUser = ?
        ');

        $prepare->bindValue(1, $user->email());
        $prepare->bindValue(2, $user->password());
        $prepare->bindValue(3, $user->id());

        return $prepare->execute();
    }

    /**
     * @param $email
     * @param $password
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function userWithCredentials($email, $password)
    {
        $prepare = $this->conn->prepare('
          SELECT idUser, email FROM users
          WHERE
            email = ? AND passw = ?
        ');
        $prepare->bindValue(1, $email);
        $prepare->bindValue(2, $password);
        $prepare->execute();

        $data = $prepare->fetch();

        if ($data) {
            $user = User::createEntity($data['email'], $data['idUser']);

            return $user;
        }

        return;
    }

    /**
     * @param $idUser
     * @param $email
     *
     * @return User|null
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function userWithSession($idUser, $email)
    {
        $prepare = $this->conn->prepare('
          SELECT idUser, email FROM users
          WHERE
            email = ? AND idUser = ?
        ');
        $prepare->bindValue(1, $email);
        $prepare->bindValue(2, $idUser);
        $prepare->execute();

        $data = $prepare->fetch();

        if ($data) {
            return User::createEntity($data['email'], $idUser);
        }

        return;
    }
}
