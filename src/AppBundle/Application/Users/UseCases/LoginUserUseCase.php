<?php

namespace AppBundle\Application\Users\UseCases;

use AppBundle\Domain\Exceptions\UserException;
use AppBundle\Domain\Users\UserRepository;

/**
 * Class LoginUserUseCase.
 */
class LoginUserUseCase
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
     * @param LoginUserRequest $loginUserRequest
     *
     * @return LoginUserResponse
     *
     * @throws UserException
     */
    public function execute(LoginUserRequest $loginUserRequest)
    {
        $response = new LoginUserResponse();

        try {
            /*
             * @var User
             */
            $user = $this->userRepository->userWithCredentials($loginUserRequest->email, $loginUserRequest->password);

            if ((null === $user) || (!$user->isValid())) {
                throw new UserException('User not exists');
            }

            $response->id = $user->id();
            $response->email = $user->email();
        } catch (UserException $e) {
            $response->addError('Not exists any user with this combination of email and password');
        } catch (\Exception $e) {
            $response->addError('Error in login process, please contact with the webmaster');
        }

        return $response;
    }
}
