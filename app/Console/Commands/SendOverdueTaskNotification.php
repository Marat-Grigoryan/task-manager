<?php

namespace App\Console\Commands;

use App\DTO\Task\TaskFiltersDTO;
use App\Enums\TaskStatusEnum;
use App\Notifications\Task\OverdueTaskNotification;
use App\Notifications\User\TaskAssignedNotification;
use App\Services\Task\TaskService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class SendOverdueTaskNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-overdue-task-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(TaskService $taskService): void
    {
        $filterDTO = new TaskFiltersDTO(
            statuses: [TaskStatusEnum::New, TaskStatusEnum::InProgress],
            userAssigned: true,
            dueDateTo: Carbon::now(),
            maxOverdueNotificationCount: 0
        );

        $tasks = $taskService->getByFilter($filterDTO);

        foreach ($tasks as $task) {
            Notification::send($task->assignedUser, new OverdueTaskNotification($task));
            $taskService->incrementOverdueNotificationCount($task->id);
        }
    }
}
