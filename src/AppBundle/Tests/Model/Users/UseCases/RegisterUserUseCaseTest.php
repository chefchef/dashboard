<?php

namespace AppBundle\Tests\Model\Users\UseCases;

use AppBundle\Application\Users\UseCases\RegisterUserRequest;
use AppBundle\Application\Users\UseCases\RegisterUserResponse;
use AppBundle\Application\Users\UseCases\RegisterUserUseCase;
use AppBundle\Domain\Users\User;
use AppBundle\Domain\Users\UserRepository;
use Prophecy\Argument;

/**
 * Class RegisterUserUseCaseTest.
 */
class RegisterUserUseCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RegisterUserUseCase
     */
    private $sut;

    /**
     *
     */
    public function testNewRegisterNotPreviousInRepository()
    {
        $email = 'eduardo@uoc.com';
        $password = $repassword = 'aaaa';
        $userRepositoryStub = $this->initRepositoryStub();

        $userRepositoryStub->userWithCredentials($email, $password)->willReturn(null);

        $registerUserResponse = new RegisterUserResponse();
        $registerUserResponse->email = $email;
        $registerUserResponse->id = mt_rand(0, 1000);

        $userRepositoryStub->register(Argument::any())->willReturn($registerUserResponse);

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $registerUserRequest = $this->createRequest($email, $password, $repassword);

        $response = $this->sut->execute($registerUserRequest);

        $this->assertSame($email, $response->email);
        $this->assertNotNull($response->id);
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function initRepositoryStub()
    {
        return $this->prophesize(UserRepository::class);
    }

    /**
     * @param $userRepositoryStub
     */
    protected function initSut($userRepositoryStub)
    {
        /*
         * @var UserRepository
         */
        $userRepositoryMock = $userRepositoryStub->reveal();

        $this->sut = new RegisterUserUseCase($userRepositoryMock);
    }

    /**
     * @param $email
     * @param $password
     * @param $repassword
     *
     * @return RegisterUserRequest
     */
    protected function createRequest($email, $password, $repassword)
    {
        $registerUserRequest = new RegisterUserRequest();
        $registerUserRequest->email = $email;
        $registerUserRequest->password = $password;
        $registerUserRequest->repassword = $repassword;

        return $registerUserRequest;
    }

    public function testNewRegisterNotPreviousInRepositoryNotCanCreateByRepository()
    {
        $email = 'eduardo@uoc.com';
        $password = $repassword = 'aaaa';
        $userRepositoryStub = $this->initRepositoryStub();

        $userRepositoryStub->userWithCredentials($email, $password)->willReturn(null);

        $registerUserResponse = new RegisterUserResponse();
        $registerUserResponse->email = $email;
        $registerUserResponse->id = mt_rand(0, 1000);

        $userRepositoryStub->register(Argument::any())->willReturn(null);

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $registerUserRequest = $this->createRequest($email, $password, $repassword);

        $response = $this->sut->execute($registerUserRequest);

        $this->assertNull($response->id);
        $this->assertNull($response->email);
        $this->assertSame('User is already register in system', $response->getErrors()[0]);

    }

    /**
     * @throws \AppBundle\Domain\Exceptions\UserException
     */
    public function testNewRegisterExistsInRepository()
    {
        $email = 'eduardo@uoc.com';
        $password = $repassword = 'aaaa';
        $userRepositoryStub = $this->initRepositoryStub();

        $userRepositoryStub->userWithCredentials($email, $password)->willReturn(User::create($email, $password));

        $registerUserResponse = new RegisterUserResponse();
        $registerUserResponse->email = $email;
        $registerUserResponse->id = mt_rand(0, 1000);

        $userRepositoryStub->register(Argument::any())->willReturn($registerUserResponse);

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $registerUserRequest = $this->createRequest($email, $password, $repassword);

        $response = $this->sut->execute($registerUserRequest);

        $this->assertSame($email, $response->email);
        $this->assertNotNull($response->id);
        $this->assertEmpty($response->getErrors());
    }

    /**
     * @throws \AppBundle\Domain\Exceptions\UserException
     */
    public function testInvalidEmail()
    {
        $email = 'INVALIDEMAIL';
        $password = $repassword = 'aaaa';
        $userRepositoryStub = $this->initRepositoryStub();

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $registerUserRequest = $this->createRequest($email, $password, $repassword);

        $response = $this->sut->execute($registerUserRequest);
        $this->assertNull($response->id);
        $this->assertNull($response->email);
        $this->assertSame('Invalid Email', $response->getErrors()[0]);
    }

    /**
     * @throws \AppBundle\Domain\Exceptions\UserException
     */
    public function testPasswordNotMatch()
    {
        $email = 'eduardo@uoc.com';
        $password = 'aaaa';
        $repassword = 'aaab';
        $userRepositoryStub = $this->initRepositoryStub();

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $registerUserRequest = $this->createRequest($email, $password, $repassword);

        $response = $this->sut->execute($registerUserRequest);
        $this->assertNull($response->id);
        $this->assertNull($response->email);
        $this->assertSame('Password don\'t match', $response->getErrors()[0]);
    }
}
