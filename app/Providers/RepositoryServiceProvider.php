<?php

namespace App\Providers;

use App\Repositories\Task\EloquentTaskRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            TaskRepository::class,
            EloquentTaskRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
