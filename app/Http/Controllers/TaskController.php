<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function show(): View
    {
        $tasks = Task::where('archived', 0)->get();

        return view('tasks', ['tasks'=>$tasks]);
    }

    public function showArchived(): View
    {
        $archived_tasks = Task::where('archived', 1)->get();

        return view('archived_tasks', ['archived_tasks'=>$archived_tasks]);
    }

    public function store(Request $request): RedirectResponse
    {

        $task = new Task;

        $task->description = $request->task_description;
        $task->due_date = $request->task_due_date;

        $task->save();

        return redirect('/tasks');
    }
}
