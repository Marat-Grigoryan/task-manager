<?php

namespace App\Listeners\User;

use App\Events\Task\UserAssignedEvent;
use App\Notifications\User\TaskAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class TaskAssignedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserAssignedEvent $event): void
    {
        Notification::send($event->task->assignedUser, new TaskAssignedNotification($event->task));
    }

    /**
     * Handle a job failure.
     */
    public function failed(UserAssignedEvent $event, Throwable $exception): void
    {
        Log::info('TaskAssignedListener failed', [
            'event' => $event,
            'exception' => $exception,
        ]);
    }
}
