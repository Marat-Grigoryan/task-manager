<?php

namespace App\Responses;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Carbon\Carbon;

readonly class TaskResponse
{
    public function __construct(
        public int            $id,
        public string         $name,
        public string         $description,
        public Carbon         $dueDate,
        public TaskStatusEnum $status,
        public Carbon         $createdAt,
        public Carbon         $updatedAt,
        public ?int           $assignedUserId,
        public ?UserResponse  $assignedUser,
    ){}

    public static function fromModel(Task $task): TaskResponse
    {
        return new TaskResponse(
            id: $task->id,
            name: $task->name,
            description: $task->description,
            dueDate: $task->due_date,
            status: $task->status,
            createdAt: $task->created_at,
            updatedAt: $task->updated_at,
            assignedUserId: $task->assigned_user_id,
            assignedUser: $task->assignedUser ? UserResponse::fromModel($task->assignedUser) : null,
        );
    }
}