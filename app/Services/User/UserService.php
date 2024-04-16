<?php

namespace App\Services\User;

use App\DTO\User\CreateUserDTO;
use App\Responses\UserResponse;
use App\Repositories\User\UserRepository;

readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ){}

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return UserResponse
     */
    public function create(string $name, string $email, string $password): UserResponse
    {
        $createUserDTO = new CreateUserDTO(
            name: $name,
            email: $email,
            password: bcrypt($password)
        );

        return $this->userRepository->create($createUserDTO);
    }

    /**
     * @param int $id
     * @return UserResponse
     */
    public function find(int $id): UserResponse
    {
        return $this->userRepository->find($id);
    }
}