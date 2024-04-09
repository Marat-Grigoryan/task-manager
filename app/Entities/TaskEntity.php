<?php

namespace App\Entities;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;

readonly class TaskEntity implements Entity
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public Carbon $due_date,
        public TaskStatusEnum $status,
        public Carbon $created_at,
        public Carbon $updated_at,
        public ?UserEntity $assignedUser,
    ){}
}