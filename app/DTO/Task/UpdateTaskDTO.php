<?php

namespace App\DTO\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;

readonly class UpdateTaskDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
        public ?Carbon $dueDate = null,
        public ?TaskStatusEnum $status = null,
        public ?int $assignedUserId = null,
        public bool $isNamePresent = false,
        public bool $isDescriptionPresent = false,
        public bool $isDueDatePresent = false,
        public bool $isStatusPresent = false,
        public bool $isAssignedUserIdPresent = false,
    ) {}
}