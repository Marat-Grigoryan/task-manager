<?php

namespace App\Repositories\Task;


use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\TaskFiltersDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Entities\TaskEntity;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepository
{
    public function create(CreateTaskDTO $createTaskDTO): TaskEntity;
    public function find(int $id): TaskEntity;

    public function update(int $id, UpdateTaskDTO $updateTaskDTO): TaskEntity;

    public function get(int $perPage, int $page): LengthAwarePaginator;

    public function delete(int $id): void;

    /**
     * @param TaskFiltersDTO $filters
     * @return TaskEntity[]
     */
    public function getByFilter(TaskFiltersDTO $filters): array;

    /**
     * @param int $id
     * @return void
     */
    public function incrementOverdueNotificationCount(int $id): void;
}