<?php

namespace App\Models;

use App\Entities\HasEntity;
use App\Entities\UserEntity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements HasEntity
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return UserEntity
     */
    public function toEntity(): UserEntity
    {
        return new UserEntity(
            id: $this->id,
            name: $this->name,
            email: $this->email,
        );
    }
}
