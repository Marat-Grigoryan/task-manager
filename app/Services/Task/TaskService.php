<?php

namespace App\Services\Task;

use App\Entities\TaskEntity;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Task\CreateTaskDTO as CreateTaskRepositoryDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Task\UpdateTaskDTO as UpdateTaskRepositoryDTO;

readonly class TaskService {
    public function __construct(
        private TaskRepository $taskRepository
    ){}

    /**
     * @param CreateTaskDTO $data
     * @return TaskEntity
     */
    public function create(CreateTaskDTO $data): TaskEntity {
        $createTaskDTO = new CreateTaskRepositoryDTO(
            name: $data->name,
            description: $data->description,
            dueDate: $data->dueDate,
            status: $data->status,
            assignedUserId: $data->assignedUserId,
        );

        return $this->taskRepository->create($createTaskDTO);
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

    public function update(int $id, UpdateTaskDTO $data): TaskEntity {
        $updateTaskDTO = new UpdateTaskRepositoryDTO(
            name: $data->name,
            description: $data->description,
            dueDate: $data->dueDate,
            status: $data->status,
            assignedUserId: $data->assignedUserId,
            isNamePresent: $data->isNamePresent,
            isDescriptionPresent: $data->isDescriptionPresent,
            isDueDatePresent: $data->isDueDatePresent,
            isStatusPresent: $data->isStatusPresent,
            isAssignedUserIdPresent: $data->isAssignedUserIdPresent,
        );

        return $this->taskRepository->update($id, $updateTaskDTO);
    }

    public function delete(int $id): void {
        $this->taskRepository->delete($id);
    }
}