<?php

namespace App\Models;

use App\Responses\TaskResponse;
use App\Enums\TaskStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property TaskStatusEnum $status
 * @property int $assigned_user_id
 * @property Carbon $due_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User|null $assignedUser
 */
class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'due_date' => 'date'
    ];

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
