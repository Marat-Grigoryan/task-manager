<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TaskTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_create_task_via_api()
    {
        $dueDate = Carbon::now()->addDays(10)->format('Y-m-d');
        $taskData = [
            'name' => 'Task Name',
            'description' => 'Task Description',
            'due_date' => $dueDate,
            'status' => 'new',
            'assigned_user_id' => $this->user->id,
        ];

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(route('task.store'), $taskData);

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Task Name',
                'description' => 'Task Description',
                'due_date' => $dueDate,
                'status' => 'new',
                'assigned_user_id' => $this->user->id,
                'assigned_user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ]
            ]);

        // Assert task is added to the database
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task Name',
            'description' => 'Task Description',
            'due_date' => $dueDate,
            'status' => 'new',
            'assigned_user_id' => $this->user->id,
        ]);
    }

    public function test_update_task_via_api()
    {
        // Create a task
        $task = Task::factory()->create([
            'assigned_user_id' => $this->user->id,
        ]);

        // New task data
        $newDueDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $newTaskData = [
            'name' => 'Updated Task Name',
            'description' => 'Updated Task Description',
            'due_date' => $newDueDate,
            'status' => 'in_progress', // Assuming the status changes to in_progress
        ];

        // Send update request
        $response = $this->withHeader('Accept', 'application/json')
            ->patch(route('task.update', ['id' => $task->id]), $newTaskData);

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Task Name',
                'description' => 'Updated Task Description',
                'due_date' => $newDueDate,
                'status' => 'in_progress',
                'assigned_user_id' => $this->user->id,
                'assigned_user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ]
            ]);

        // Assert task is updated in the database
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task Name',
            'description' => 'Updated Task Description',
            'due_date' => $newDueDate,
            'status' => 'in_progress',
            'assigned_user_id' => $this->user->id,
        ]);
    }

    public function test_delete_task_via_api()
    {
        // Create a task
        $task = Task::factory()->create([
            'assigned_user_id' => $this->user->id,
        ]);

        // Send delete request
        $response = $this->withHeader('Accept', 'application/json')
            ->delete(route('task.destroy', ['id' => $task->id]));

        // Assert response status
        $response->assertStatus(204);

        // Assert task is deleted from the database
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_get_task_via_api()
    {
        // Create a task
        $task = Task::factory()->create([
            'assigned_user_id' => $this->user->id,
        ]);

        // Send get request
        $response = $this->withHeader('Accept', 'application/json')
            ->get(route('task.show', ['id' => $task->id]));

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'name' => $task->name,
                'description' => $task->description,
                'due_date' => $task->due_date->format('Y-m-d'),
                'status' => $task->status->value,
                'assigned_user_id' => $task->assigned_user_id,
                'assigned_user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ]
            ]);
    }

    public function test_get_tasks_via_api()
    {
        // Create tasks
        $tasks = Task::factory()->count(5)->create([
            'assigned_user_id' => $this->user->id,
        ]);

        // Send get request
        $response = $this->withHeader('Accept', 'application/json')
            ->get(route('task.index', ['page' => 1, 'per_page' => 5]));

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'description',
                        'due_date',
                        'status',
                        'assigned_user_id',
                    ]
                ]
            ]);
    }

    public function test_change_task_assign_user_via_api()
    {
        // Create a task
        $task = Task::factory()->create([
            'assigned_user_id' => null,
        ]);

        // Send assign request
        $response = $this->withHeader('Accept', 'application/json')
            ->post(route('task.changeAssignUser', ['id' => $task->id]), ['assigned_user_id' => $this->user->id]);

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'name' => $task->name,
                'description' => $task->description,
                'due_date' => $task->due_date->format('Y-m-d'),
                'status' => $task->status->value,
                'assigned_user_id' => $this->user->id,
                'assigned_user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ]
            ]);

        // Assert task is updated in the database
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'assigned_user_id' => $this->user->id,
        ]);
    }
}
