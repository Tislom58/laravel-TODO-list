<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class   TaskController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find(Auth::id());
        $tasks = $user->tasks;

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find(Auth::id());
        $tags = $user->tags;

        return view('tasks.create', [
            'tags' => $tags,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $task = new Task();
        $user = User::find(Auth::id());

        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->user_id = $user->id;

        $task->save();

        if(isset($request->tags)){
            $tags = $user->tags()
                ->whereIn('name', $request->tags)
                ->pluck('id');

            $task->tags()->attach($tags);
        }

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

    public function edit(string $id): Factory|View|Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $task = Task::find($id);

        if (User::find(Auth::id())->id === $task->user_id)
        {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/tasks');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $task = Task::find($id);

        $task->description = $request->description;
        $task->due_date = $request->due_date;

        $task->save();

        if($request->tags)
        {
            $tag_keys = User::find(Auth::id())
                ->tags()
                ->whereIn('name', $request->tags)
                ->pluck('id');

            $task->tags()->sync($tag_keys);
        }

        return redirect('/tasks');
    }

    public function filter(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find(Auth::id());
        $tag_keys = $user->tags()
            ->whereIn('name', $request->filter)
            ->pluck('id');

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
