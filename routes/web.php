<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/create', [TaskController::class, 'create']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{id}', [TaskController::class, 'complete']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
Route::get('tasks/{id}/edit', [TaskController::class, 'edit']);
Route::put('tasks/{id}', [TaskController::class, 'update']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/create', [TagController::class, 'create']);
Route::post('/tags', [TagController::class, 'store']);
Route::delete('/tags/{id}', [TagController::class, 'destroy']);
Route::get('tags/{id}/edit', [TagController::class, 'edit']);
Route::put('tags/{id}', [TagController::class, 'update']);

