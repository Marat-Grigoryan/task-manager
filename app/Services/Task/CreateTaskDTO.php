<?php

namespace App\Services\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;

readonly class CreateTaskDTO {
    public function __construct(
        public string $name,
        public string $description,
        public Carbon $dueDate,
        public TaskStatusEnum $status,
        public ?int $assignedUserId
    ){}
}