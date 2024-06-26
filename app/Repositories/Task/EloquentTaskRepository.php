<?php

namespace App\Repositories\Task;

use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\TaskFiltersDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Responses\TaskResponse;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class EloquentTaskRepository implements TaskRepository
{
    public function create(CreateTaskDTO $createTaskDTO): TaskResponse
    {
        $task = new Task();

        $task->name = $createTaskDTO->name;
        $task->description = $createTaskDTO->description;
        $task->due_date = $createTaskDTO->dueDate;
        $task->status = $createTaskDTO->status;
        $task->assigned_user_id = $createTaskDTO->assignedUserId;

        $task->save();

        $task->load('assignedUser');

        return TaskResponse::fromModel($task);
    }

    /**
     * @param int $id
     * @return TaskResponse
     */
    public function find(int $id): TaskResponse
    {
        /** @var Task $task */
        $task = Task::query()->with(['assignedUser'])->findOrFail($id);

        return TaskResponse::fromModel($task);
    }

    /**
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function get(int $perPage, int $page): LengthAwarePaginator
    {
        $tasks = Task::query()->forPage($page)->paginate($perPage);

        $taskResponses = array_map(function ($task) {
            return TaskResponse::fromModel($task);
        }, $tasks->items());

        return new LengthAwarePaginator(
            $taskResponses,
            $tasks->total(),
            $tasks->perPage(),
            $tasks->currentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function update(int $id, UpdateTaskDTO $updateTaskDTO): TaskResponse
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);

        if ($updateTaskDTO->isNamePresent) {
            $task->name = $updateTaskDTO->name;
        }

        if ($updateTaskDTO->isDescriptionPresent) {
            $task->description = $updateTaskDTO->description;
        }

        if ($updateTaskDTO->isDueDatePresent) {
            $task->due_date = $updateTaskDTO->dueDate;
        }

        if ($updateTaskDTO->isStatusPresent) {
            $task->status = $updateTaskDTO->status;
        }

        if ($updateTaskDTO->isAssignedUserIdPresent) {
            $task->assigned_user_id = $updateTaskDTO->assignedUserId;
        }

        $task->save();

        $task->load('assignedUser');

        return TaskResponse::fromModel($task);
    }

    public function delete(int $id): void
    {
        Task::query()->findOrFail($id)->delete();
    }

    /**
     * @param TaskFiltersDTO $filters
     * @return TaskResponse[]
     */
    public function getByFilter(TaskFiltersDTO $filters): array
    {
        $tasksQuery = Task::query()->with(['assignedUser']);

        if (!empty($filters->statuses)) {
            $tasksQuery->whereIn('status', $filters->statuses);
        }

        if ($filters->userAssigned === true) {
            $tasksQuery->whereNotNull('assigned_user_id');
        }

        if ($filters->userAssigned === false) {
            $tasksQuery->whereNull('assigned_user_id');
        }

        if ($filters->dueDateFrom) {
            $tasksQuery->where('due_date', '>=', $filters->dueDateFrom);
        }

        if ($filters->dueDateTo) {
            $tasksQuery->where('due_date', '<=', $filters->dueDateTo);
        }

        if (!is_null($filters->maxOverdueNotificationCount)) {
            $tasksQuery->where('overdue_notification_count', '<=', $filters->maxOverdueNotificationCount);
        }

        return $tasksQuery->get()->map(fn(Task $task) => TaskResponse::fromModel($task))->all();
    }

    /**
     * @param int $id
     * @return void
     */
    public function incrementOverdueNotificationCount(int $id): void
    {
        Task::query()->where('id', $id)->increment('overdue_notification_count');
    }
}