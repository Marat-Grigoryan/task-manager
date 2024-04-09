<?php

namespace App\Repositories\Task;


use App\Entities\TaskEntity;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepository
{
    public function create(CreateTaskDTO $createTaskDTO): TaskEntity;
    public function find(int $id): TaskEntity;

    public function update(int $id, UpdateTaskDTO $updateTaskDTO): TaskEntity;

    public function get(int $perPage, int $page): LengthAwarePaginator;

    public function delete(int $id): void;
}