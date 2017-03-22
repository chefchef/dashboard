<?php

namespace AppBundle\Application\Users\UseCases;

use AppBundle\Domain\Exceptions\UserException;
use AppBundle\Domain\Users\User;
use AppBundle\Domain\Users\UserRepository;

/**
 * Class LoginUserUseCase.
 */
class RegisterUserUseCase
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * LoginUserUseCase constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterUserRequest $request
     *
     * @return RegisterUserResponse
     *
     * @throws UserException
     */
    public function execute(RegisterUserRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $repassword = $request->repassword;

        $response = new RegisterUserResponse();

        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response->addError('Invalid Email');
        }

        if ($password !== $repassword) {
            $response->addError('Password don\'t match');
        }

        if (empty($response->getErrors())) {
            try {
                $user = User::create($email, $password);
                $res = $this->userRepository->register($user);

                if (!$res) {
                    throw new UserException('User not create');
                }

                $response->email = $user->email();
                $response->id = $user->id();
            } catch (\Exception $e) {
                $response->addError('User is already register in system');
            }
        }

        return $response;
    }
}
