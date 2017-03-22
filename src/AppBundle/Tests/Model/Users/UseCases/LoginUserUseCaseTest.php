<?php

namespace AppBundle\Tests\Model\Users\UseCases;

use AppBundle\Application\Users\UseCases\LoginUserRequest;
use AppBundle\Application\Users\UseCases\LoginUserResponse;
use AppBundle\Application\Users\UseCases\LoginUserUseCase;
use AppBundle\Domain\Users\User;
use AppBundle\Domain\Users\UserRepository;

/**
 * Class LoginUserUseCaseTest.
 */
class LoginUserUseCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginUserUseCase
     */
    private $sut;

    /**
     *
     */
    public function testCorrectLogin()
    {
        $email = 'eduardo@uoc.com';

        $userRepositoryStub = $this->initRepositoryStub();
        $loginUserResponse = new LoginUserResponse();
        $loginUserResponse->email = $email;
        $loginUserResponse->id = mt_rand(0, 1000);

        $user = User::createEntity($email, '1212');
        $userRepositoryStub->userWithCredentials($email, null)->willReturn($user);

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $loginUserRequest = $this->createRequest($email);

        $response = $this->sut->execute($loginUserRequest);

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

        $this->sut = new LoginUserUseCase($userRepositoryMock);
    }

    /**
     * @param $email
     *
     * @return LoginUserRequest
     */
    protected function createRequest($email)
    {
        $loginUserRequest = new LoginUserRequest();
        $loginUserRequest->email = $email;

        return $loginUserRequest;
    }

    public function testIncorrectLoginWithExceptionInRepository()
    {
        $email = 'eduardo@uoc.com';

        $userRepositoryStub = $this->initRepositoryStub();

        $loginUserResponse = new LoginUserResponse();
        $loginUserResponse->email = $email;
        $loginUserResponse->id = mt_rand(0, 1000);

        $userRepositoryStub->userWithCredentials($email, null)->willThrow(new \Exception('Invalid login'));

        $this->initSut($userRepositoryStub);

        $loginUserRequest = $this->createRequest($email);

        $response = $this->sut->execute($loginUserRequest);

        $this->assertNull($response->email);
        $this->assertNull($response->id);
    }

    public function testIncorrectLoginInRepository()
    {
        $email = 'eduardo@uoc.com';

        $userRepositoryStub = $this->initRepositoryStub();
        $loginUserResponse = new LoginUserResponse();
        $loginUserResponse->email = $email;
        $loginUserResponse->id = null;

        $user = User::createFormEntity();
        $userRepositoryStub->userWithCredentials($email, null)->willReturn($user);

        /*
         * @var $userRepositoryMock UserRepository
         */
        $this->initSut($userRepositoryStub);

        $loginUserRequest = $this->createRequest($email);

        $response = $this->sut->execute($loginUserRequest);

        $this->assertNull($response->id);
        $this->assertNull($response->email);
    }
}
