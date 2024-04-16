<?php

namespace App\Repositories\User;

use App\DTO\User\CreateUserDTO;
use App\Responses\UserResponse;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{
    /**
     * @param CreateUserDTO $createUserDTO
     * @return UserResponse
     */
    public function create(CreateUserDTO $createUserDTO): UserResponse
    {
        $user = new User();
        $user->name = $createUserDTO->name;
        $user->email = $createUserDTO->email;
        $user->password = $createUserDTO->password;
        $user->save();

        return UserResponse::fromModel($user);
    }

    /**
     * @param int $id
     * @return UserResponse
     */
    public function find(int $id): UserResponse
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);

        return UserResponse::fromModel($user);
    }
}