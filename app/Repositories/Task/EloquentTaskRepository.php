<?php

namespace App\Repositories\Task;

use App\Entities\TaskEntity;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class EloquentTaskRepository implements TaskRepository
{
    public function create(CreateTaskDTO $createTaskDTO): TaskEntity
    {
        $task = new Task();

        $task->name = $createTaskDTO->name;
        $task->description = $createTaskDTO->description;
        $task->due_date = $createTaskDTO->dueDate;
        $task->status = $createTaskDTO->status;
        $task->assigned_user_id = $createTaskDTO->assignedUserId;

        $task->save();

        $task->load('assignedUser');

        return $task->toEntity();
    }

    /**
     * @param int $id
     * @return TaskEntity
     */
    public function find(int $id): TaskEntity
    {
        /** @var Task $task */
        $task = Task::query()->with(['assignedUser'])->findOrFail($id);

        return $task->toEntity();
    }

    /**
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function get(int $perPage, int $page): LengthAwarePaginator
    {
        $tasks = Task::query()->forPage($page)->paginate($perPage);

        $taskEntities = array_map(function ($task) {
            return $task->toEntity();
        }, $tasks->items());

        return new LengthAwarePaginator(
            $taskEntities,
            $tasks->total(),
            $tasks->perPage(),
            $tasks->currentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function update(int $id, UpdateTaskDTO $updateTaskDTO): TaskEntity
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

        return $task->toEntity();
    }

    public function delete(int $id): void
    {
        Task::query()->findOrFail($id)->delete();
    }
}