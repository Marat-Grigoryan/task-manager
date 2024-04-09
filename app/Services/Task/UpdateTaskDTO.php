<?php

namespace App\Services\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;

class UpdateTaskDTO
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?Carbon $dueDate,
        public ?TaskStatusEnum $status,
        public ?int $assignedUserId,
        public bool $isNamePresent,
        public bool $isDescriptionPresent,
        public bool $isDueDatePresent,
        public bool $isStatusPresent,
        public bool $isAssignedUserIdPresent
    ) {}
}