<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamInviteController;
use App\Http\Controllers\TeamTagController;
use App\Http\Controllers\TeamTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    // Tasks routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create']);
    Route::put('tasks/filter', [TaskController::class, 'filter']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{id}', [TaskController::class, 'complete']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);

    // Tags routes
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create', [TagController::class, 'create']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);
    Route::get('/tags/{id}/edit', [TagController::class, 'edit']);
    Route::put('/tags/{id}', [TagController::class, 'update']);

    // Teams routes
    Route::get('/team', [TeamController::class, 'index'])->name('team.index');
    Route::post('/team', [TeamController::class, 'store'])->name('team.store');
    Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
    Route::get('/team/join', [TeamController::class, 'join'])->name('team.join');
    Route::post('/team/invite', [TeamInviteController::class, 'store'])->name('team.invite');
    Route::patch('/team/invite/accept', [TeamInviteController::class, 'accept'])->name('team.invite.accept');
    Route::patch('/team/invite/decline', [TeamInviteController::class, 'decline'])->name('team.invite.decline');
    Route::get('/team-task/create', [TeamTaskController::class, 'create'])->name('team.task.create');
    Route::post('/team-task-create', [TeamTaskController::class, 'store'])->name('team.task.store');
    Route::delete('/team-task-delete/{id}', [TeamTaskController::class, 'destroy'])->name('team.task.destroy');
    Route::patch('/team-task-complete/{id}', [TeamTaskController::class, 'complete'])->name('team.task.complete');
    Route::get('/team-task-edit/{id}', [TeamTaskController::class, 'edit'])->name('team.task.edit');
    Route::put('/team-task-update/{id}', [TeamTaskController::class, 'update'])->name('team.task.update');
    Route::patch('/team-task/{id}/toggle-email-reminder', [TeamTaskController::class, 'toggle_email_reminder'])
        ->name('team.toggle-email-reminder');
    Route::patch('/team-task/{id}/toggle-push-reminder', [TeamTaskController::class, 'toggle_push_reminder'])
        ->name('team.toggle-push-reminder');
    Route::get('/team-tag/create', [TeamTagController::class, 'create'])->name('team.tag.create');
    Route::post('/team-tag/store', [TeamTagController::class, 'store'])->name('team.tag.store');
    Route::get('/team-tag/{id}/edit', [TeamTagController::class, 'edit'])->name('team.tag.edit');
    Route::put('/team-tag/{id}/update', [TeamTagController::class, 'update'])->name('team.tag.update');
    Route::delete('/team-tag/{id}/destroy', [TeamTagController::class, 'destroy'])->name('team.tag.destroy');
});

require __DIR__.'/auth.php';
