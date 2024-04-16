<?php

namespace App\Entities;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Carbon\Carbon;

readonly class TaskEntity implements Entity
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public Carbon $dueDate,
        public TaskStatusEnum $status,
        public Carbon $createdAt,
        public Carbon $updatedAt,
        public int $assignedUserId,
        public ?UserEntity $assignedUser,
    ){}

    public static function fromModel(Task $task): TaskEntity
    {
        return new TaskEntity(
            id: $task->id,
            name: $task->name,
            description: $task->description,
            dueDate: $task->due_date,
            status: $task->status,
            createdAt: $task->created_at,
            updatedAt: $task->updated_at,
            assignedUserId: $task->assigned_user_id,
            assignedUser: $task->assignedUser ? UserEntity::fromModel($task->assignedUser) : null,
        );
    }
}