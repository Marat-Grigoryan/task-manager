<?php

namespace App\Repositories\Task;


use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\TaskFiltersDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Responses\TaskResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepository
{
    public function create(CreateTaskDTO $createTaskDTO): TaskResponse;
    public function find(int $id): TaskResponse;

    public function update(int $id, UpdateTaskDTO $updateTaskDTO): TaskResponse;

    public function get(int $perPage, int $page): LengthAwarePaginator;

    public function delete(int $id): void;

    /**
     * @param TaskFiltersDTO $filters
     * @return TaskResponse[]
     */
    public function getByFilter(TaskFiltersDTO $filters): array;

    /**
     * @param int $id
     * @return void
     */
    public function incrementOverdueNotificationCount(int $id): void;
}