<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'show']);

Route::get('/archived-tasks', [TaskController::class, 'showArchived']);

Route::post('/tasks', [TaskController::class, 'store']);
