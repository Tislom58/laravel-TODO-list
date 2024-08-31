<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class TaskController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $tasks = Task::where('archived', 0)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $tags = Tag::all('name');

        return view('tasks.create', [
            'tags' => $tags,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $task = new Task();
        $task->description = $request->description;
        $task->due_date = $request->due_date;

        $task->save();

        $tags = Tag::whereIn('name', $request->tags)->pluck('id');

        $task->tags()->attach($tags);

        return redirect('/tasks');
    }

    public function complete(string $id): RedirectResponse
    {
        $task = Task::find($id);
        $task->archived = 1;

        $task->save();

        return redirect('/tasks');
    }

    public function destroy(string $id): RedirectResponse
    {
        Task::find($id)->delete();

        return redirect('/tasks');
    }

    public function edit(string $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $task = Task::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $task = Task::find($id);

        $task->description = $request->description;
        $task->due_date = $request->due_date;

        $task->save();

        $tag_keys = Tag::whereIn('name', $request->tags)->pluck('id');
        $task->tags()->sync($tag_keys);

        return redirect('/tasks');
    }

    public function filter(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $tag_keys = Tag::whereIn('name', $request->filter)->pluck('id');

        $task_keys = Task::whereHas('tags', function (Builder $query) use ($tag_keys) {
            $query->whereIn('tag_id', $tag_keys)
                ->groupBy('task_id')
                ->havingRaw('COUNT(*) = ?', [count($tag_keys)]);
        })->pluck('id');

        $tasks = Task::find($task_keys);

        return view('tasks.filter', [
            'tasks' => $tasks,
        ]);
    }
}
