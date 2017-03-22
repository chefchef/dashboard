<?php

namespace AppBundle\Tests\Model\Users;

use AppBundle\Domain\Users\User;
use AppBundle\Domain\Users\UserPasswordGenerator;

/**
 * Class UserTest.
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $sut;

    public function testNotInitUser()
    {
        $this->assertNull($this->sut->id());
        $this->assertNull($this->sut->email());
        $this->assertNull($this->sut->password());
    }

    public function testSetgetId()
    {
        $id = 'dasdasdsa232323dasdas';
        $this->sut->setId($id);

        $this->assertSame($id, $this->sut->id());
    }

    public function testSetgetEmail()
    {
        $email = 'aa@aa.es';
        $this->sut->setEmail($email);

        $this->assertSame($email, $this->sut->email());
    }

    public function testSetgetPassword()
    {
        $password = 'dasda3DSADas';
        $this->sut->setPassword($password);

        $this->assertSame($password, $this->sut->password());
    }

    public function testSetgetRePassword()
    {
        $password = 'dasda3DSADas';
        $this->sut->setRepassword($password);

        $this->assertSame($password, $this->sut->repassword());
    }

    public function testNewUser()
    {
        $email = 'aa@aa.es';
        $password = 'dasdas4$DASDAS';
        $this->sut = User::create($email, $password);

        $this->assertNotNull($this->sut->id());
        $this->assertSame($email, $this->sut->email());
        $this->assertSame(UserPasswordGenerator::generate($password), $this->sut->password());
    }

    public function testValidUser()
    {
        $user = User::createEntity('aa@aa.es', 2121);
        $this->assertTrue($user->isValid());
    }

    public function testInvalidUser()
    {
        $user = User::createEntity(null, 2121);
        $this->assertFalse($user->isValid());
    }

    protected function setUp()
    {
        $this->sut = User::createFormEntity();
    }
}
