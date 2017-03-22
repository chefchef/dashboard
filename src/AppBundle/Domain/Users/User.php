<?php

namespace AppBundle\Domain\Users;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User.
 */
class User implements UserEntity
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    protected $id;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     *
     * @var
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     *
     * @var
     */
    protected $password;

    protected $repassword;

    /**
     * User constructor.
     *
     * @param $email
     * @param $password
     * @param bool|true $new
     */
    private function __construct($email = null, $password = null, $new = true)
    {
        if ($new) {
            $this->id = Uuid::uuid4()->toString();
        }

        $this->email = $email;

        if (null !== $password) {
            $this->password = UserPasswordGenerator::generate($password);
        }
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function repassword()
    {
        return $this->repassword;
    }

    /**
     * @param mixed $repassword
     */
    public function setRepassword($repassword)
    {
        $this->repassword = $repassword;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (null !== $this->id()) && (null !== $this->email());
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @param $password
     *
     * @return User
     */
    public static function create($email, $password)
    {
        return new self($email, $password, true);
    }

    /**
     * @param $email
     * @param $idUser
     *
     * @return User
     */
    public static function createEntity($email, $idUser)
    {
        $user = new self($email, null, false);
        $user->setId($idUser);

        return $user;
    }

    /**
     * @return mixed
     */
    public static function createFormEntity()
    {
        return new self(null, null, false);
    }
}
