<?php

namespace App\Repositories\User;


use App\Entities\UserEntity;

interface UserRepository
{
    public function create(CreateUserDTO $createUserDTO): UserEntity;
    public function find(int $id): UserEntity;
}