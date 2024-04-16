<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Notifications\Notifiable;

readonly class UserEntity implements Entity
{
    use Notifiable;

    public function __construct(
        private int    $id,
        private string $name,
        private string $email,
    ){}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function fromModel(User $user): UserEntity
    {
        return new UserEntity(
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }
}