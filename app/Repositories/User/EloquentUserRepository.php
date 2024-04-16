<?php

namespace App\Repositories\User;

use App\DTO\User\CreateUserDTO;
use App\Entities\UserEntity;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{
    /**
     * @param CreateUserDTO $createUserDTO
     * @return UserEntity
     */
    public function create(CreateUserDTO $createUserDTO): UserEntity
    {
        $user = new User();
        $user->name = $createUserDTO->name;
        $user->email = $createUserDTO->email;
        $user->password = $createUserDTO->password;
        $user->save();

        return UserEntity::fromModel($user);
    }

    /**
     * @param int $id
     * @return UserEntity
     */
    public function find(int $id): UserEntity
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);

        return UserEntity::fromModel($user);
    }
}