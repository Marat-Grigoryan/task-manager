<?php

namespace App\Services\Task;

use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\TaskFiltersDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Entities\TaskEntity;
use App\Events\Task\UserAssignedEvent;
use App\Repositories\Task\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class TaskService {
    public function __construct(
        private TaskRepository $taskRepository
    ){}

    /**
     * @param CreateTaskDTO $createTaskDTO
     * @return TaskEntity
     */
    public function create(CreateTaskDTO $createTaskDTO): TaskEntity {
        $task = $this->taskRepository->create($createTaskDTO);

        if ($createTaskDTO->assignedUserId !== null) {
            UserAssignedEvent::dispatch($task);
        }

        return $task;
    }

    /**
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function get(int $perPage, int $page): LengthAwarePaginator {
        return $this->taskRepository->get($perPage, $page);
    }

    /**
     * @param int $id
     * @return TaskEntity
     */
    public function find(int $id): TaskEntity {
        return $this->taskRepository->find($id);
    }

    /**
     * @param int $id
     * @param UpdateTaskDTO $updateTaskDTO
     * @return TaskEntity
     */
    public function update(int $id, UpdateTaskDTO $updateTaskDTO): TaskEntity {
        $oldAssignedUserId = null;

        if ($updateTaskDTO->assignedUserId !== null) {
            $oldAssignedUserId = $this->taskRepository->find($id)->assignedUserId;
        }

        $task = $this->taskRepository->update($id, $updateTaskDTO);

        if ($updateTaskDTO->assignedUserId !== null && $oldAssignedUserId !== $updateTaskDTO->assignedUserId) {
            UserAssignedEvent::dispatch($task);
        }

        return $task;
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void {
        $this->taskRepository->delete($id);
    }

    /**
     * @param TaskFiltersDTO $filters
     * @return TaskEntity[]
     */
    public function getOverdueTasks(TaskFiltersDTO $filters): array {
        return $this->taskRepository->getByFilter($filters);
    }

    /**
     * @param int $id
     * @return void
     */
    public function incrementOverdueNotificationCount(int $id): void {
        $this->taskRepository->incrementOverdueNotificationCount($id);
    }
}