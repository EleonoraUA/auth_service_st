<?php


namespace App\Service;

use App\Entity\User;
use App\Exceptions\InvalidUserDataException;
use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserManager
 */
class UserManager implements UserManagerInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserManager constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param array $userData
     * @return User
     * @throws InvalidUserDataException
     * @throws UserAlreadyExistsException
     */
    public function createUserFromData(array $userData): User
    {
        if (!$this->isValidUserData($userData)) {
            throw new InvalidUserDataException('Missed required fields for user data');
        }

        if ($this->checkUserExists($userData['username'])) {
            throw new UserAlreadyExistsException('user by nickname exists');
        }

        $user = $this->buildObjectFromData($userData);
        $this->userRepository->createUser($user);

        return $user;
    }

    /**
     * @param string $username
     * @return bool
     */
    protected function checkUserExists(string $username): bool
    {
        try {
            return $this->userRepository->findByUsername($username) instanceof User;
        } catch (UserNotFoundException $exception) {
            return false;
        }
    }

    /**
     * @param array $userData
     * @return User
     */
    protected function buildObjectFromData(array $userData): User
    {
        $user = new User;
        $user
            ->setId(uniqid())
            ->setAge($userData['age'])
            ->setFirstName($userData['firstname'])
            ->setLastName($userData['lastname'])
            ->setPassword($this->passwordEncoder->encodePassword($user, $userData['password']))
            ->setUsername($userData['username']);

        return $user;
    }

    /**
     * @param array $userData
     * @return bool
     */
    protected function isValidUserData(array $userData): bool
    {
        return
            !empty($userData['username']) &&
            !empty($userData['password']) &&
            !empty($userData['age']) &&
            !empty($userData['firstname']) &&
            !empty($userData['lastname']);
    }
}