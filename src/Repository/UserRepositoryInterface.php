<?php


namespace App\Repository;

use App\Entity\User;
use App\Exceptions\UserNotFoundException;

/**
 * Interface UserRepositoryInterface
 * @package App\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(string $username): User;

    /**
     * @param User $user
     */
    public function createUser(User $user): void;
}