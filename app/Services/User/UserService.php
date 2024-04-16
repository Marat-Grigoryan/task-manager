<?php

namespace App\Services\User;

use App\DTO\User\CreateUserDTO;
use App\Entities\UserEntity;
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
     * @return UserEntity
     */
    public function create(string $name, string $email, string $password): UserEntity
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
     * @return UserEntity
     */
    public function find(int $id): UserEntity
    {
        return $this->userRepository->find($id);
    }
}