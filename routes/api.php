<?php

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/users', [UserController::class, 'store'])->name('user.create');
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('tasks')->as('task.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('{id}', [TaskController::class, 'show'])->name('show');
        Route::patch('{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('{id}', [TaskController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/change-assign-user', [TaskController::class, 'changeAssignedUser'])->name('changeAssignUser');
    });
});
