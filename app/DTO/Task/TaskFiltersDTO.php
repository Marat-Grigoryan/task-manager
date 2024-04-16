<?php

namespace App\DTO\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;

class TaskFiltersDTO
{
    /**
     * @param TaskStatusEnum[]|null $statuses
     * @param bool|null $userAssigned
     * @param Carbon|null $dueDateFrom
     * @param Carbon|null $dueDateTo
     * @param int|null $maxOverdueNotificationCount
     */
    public function __construct(
        public ?array $statuses = null,
        public ?bool $userAssigned = null,
        public ?Carbon $dueDateFrom = null,
        public ?Carbon $dueDateTo = null,
        public ?int $maxOverdueNotificationCount = null
    ) {}
}