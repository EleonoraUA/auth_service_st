<?php


namespace App\Service;

use App\Entity\User;
use App\Exceptions\InvalidUserDataException;

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
     */
    public function createUserFromData(array $userData): User;
}