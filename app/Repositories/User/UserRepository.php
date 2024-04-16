<?php

namespace App\Repositories\User;


use App\DTO\User\CreateUserDTO;
use App\Responses\UserResponse;

interface UserRepository
{
    public function create(CreateUserDTO $createUserDTO): UserResponse;
    public function find(int $id): UserResponse;
}