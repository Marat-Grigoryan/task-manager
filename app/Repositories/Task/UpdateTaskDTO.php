<?php

namespace App\Repositories\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;

readonly class UpdateTaskDTO
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