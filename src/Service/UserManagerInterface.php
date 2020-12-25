<?php


namespace App\Service;

use App\Entity\User;
use App\Exceptions\InvalidUserDataException;
use App\Exceptions\UserAlreadyExistsException;

/**
 * Interface UserManagerInterface
 * @package App\Service
 */
interface UserManagerInterface
{
    /**
     * @param array $userData
     * @return User
     * @throws InvalidUserDataException
     * @throws UserAlreadyExistsException
     */
    public function createUserFromData(array $userData): User;
}