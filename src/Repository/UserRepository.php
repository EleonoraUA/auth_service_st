<?php

namespace App\Repository;


use App\Entity\User;
use App\Exceptions\UserNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserRepository
 */
class UserRepository implements UserRepositoryInterface
{
    protected const FILE_FORMAT = '.json';

    protected const SERIALIZER_FORMAT = 'json';

    /**
     * @var string
     */
    protected $userFilesSaveDir;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * UserRepository constructor.
     * @param Filesystem $filesystem
     * @param string $userFilesSaveDir
     * @param SerializerInterface $serializer
     */
    public function __construct(Filesystem $filesystem, string $userFilesSaveDir, SerializerInterface $serializer)
    {
        $this->userFilesSaveDir = $userFilesSaveDir;
        $this->filesystem = $filesystem;
        $this->serializer = $serializer;
    }

    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(string $username): User
    {
        $userPath = $this->getUserPath($username);
        if (!$this->filesystem->exists($userPath)) {
            throw new UserNotFoundException('No user in storage by username ' . $username);
        }

        $userData = file_get_contents($userPath);

        return $this->serializer->deserialize($userData, User::class, self::SERIALIZER_FORMAT);
    }

    /**
     * @param User $user
     */
    public function createUser(User $user): void
    {
        $serializedUser = $this->serializer->serialize($user, self::SERIALIZER_FORMAT);

        $userPath = $this->getUserPath($user->getUsername());

        $this->filesystem->appendToFile($userPath, $serializedUser);
    }

    /**
     * @param string $username
     * @return string
     */
    protected function getUserPath(string $username): string
    {
        return $this->userFilesSaveDir . sha1($username) . self::FILE_FORMAT;
    }
}